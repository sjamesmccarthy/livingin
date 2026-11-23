/*
 * The Pink Goat footer credit (vanilla-JS port of PinkGoat.tsx from leadlatte).
 * Click the goat in the footer and Biscuit walks across the middle of the screen,
 * jumps, chews on something at the right edge and wanders off. Click her mid-walk
 * and she stops and says where to find her. Decorative: the overlay ignores
 * pointer events (except on Biscuit herself) and is hidden from assistive tech.
 *
 * Markup expected in the footer:
 *   <button type="button" class="pink-goat-btn"><span>Pink Goat</span><img src="/assets/images/pink-goat-logo.png" alt=""></button>
 */
(function () {
  "use strict";
  if (window.__pinkGoatLoaded) return;
  window.__pinkGoatLoaded = true;

  var GOAT_WIDTH = 190;
  var GOAT_WIDTH_SMALL = 120;
  var PHONE_MAX = 640;
  var phoneBox = null; // set per bubble on phones: { left, width, tail }

  var LOOK_LINES = [
    "Hey! Hey! Look at me! Watch this jump!",
    "Eyes on me! This is my best jump yet!",
    "Psst! Over here! Watch this!",
    "Ready? Watch me jump!",
    "Look look look! Here comes a big one!",
    "Hey, you! Yes, you! Check this out!",
  ];
  var CHEW_LINES = [
    "Is that edible? I\u2019m going to chew it. Yep, definitely edible.",
    "Mmm, what\u2019s this? Chewing it. Tastes like victory.",
    "Is this food? Only one way to find out\u2026 nom nom.",
    "I\u2019m just going to nibble this a little. For science.",
    "That looks tasty. Chomp chomp. Yep, delicious.",
    "Don\u2019t mind me, just snacking. Totally edible.",
  ];
  function pick(a) { return a[Math.floor(Math.random() * a.length)]; }
  var EDGE_GAP = 12;
  var WALK_SPEED = 0.16; // px per ms
  var GLOW =
    "drop-shadow(0 3px 6px rgba(75,85,99,0.35)) drop-shadow(0 0 16px rgba(107,114,128,0.35))";
  var PINK = "#db2777";
  var INK = "#111827";
  var BUBBLE_FONT = '"Fredoka", "Comic Sans MS", "Chalkboard SE", cursive';
  var BUBBLE_FONT_URL =
    "https://fonts.googleapis.com/css2?family=Fredoka:wght@500;600&display=swap";

  var CAUGHT_URL = "https://findthepinkgoat.com";
  var CAUGHT_LINK = "findthepinkgoat.com";
  var GREETINGS = [
    "Hey there", "Hi stranger", "Yo", "Hello", "Howdy", "Howdy partner", "Hey cowboy",
    "Hiya", "Well hello there", "What's up", "Greetings, earthling",
  ];
  var TAIL_FILL = "M2 0 C10 4 14 20 18 30 C20 34 22 33 22 30 C22 18 26 6 38 0 Z";
  var TAIL_LINE = "M2 0 C10 4 14 20 18 30 C20 34 22 33 22 30 C22 18 26 6 38 0";

  var running = false;

  // ---- button styling (so the footer markup needs no extra CSS) -------------
  var style = document.createElement("style");
  style.textContent =
    ".pink-goat-btn{background:none;border:0;padding:0;margin:0;font:inherit;color:inherit;" +
    "cursor:pointer;display:inline-flex;align-items:center;gap:.25rem;vertical-align:middle}" +
    ".pink-goat-btn span{color:#f9559d}" +
    ".pink-goat-btn img{height:20px;width:auto;display:block}" +
    ".pink-goat-btn:disabled{cursor:default}";
  document.head.appendChild(style);

  function loadFont() {
    if (document.getElementById("pink-goat-font")) return;
    var link = document.createElement("link");
    link.id = "pink-goat-font";
    link.rel = "stylesheet";
    link.href = BUBBLE_FONT_URL;
    document.head.appendChild(link);
  }

  // Finale: once the goat is off screen, a big angled pink banner pops in, types
  // out the domain, holds ~2.5s, then dissolves.
  function showBanner() {
    var el = mk(
      "div",
      "position:fixed;left:50%;top:50%;z-index:100001;pointer-events:none;white-space:nowrap;" +
        "padding:.35em .7em;background:#f9559d;color:#fff;" +
        "font:800 clamp(1.1rem,6vw,4.5rem)/1.1 ui-monospace,'SF Mono',Menlo,Consolas,monospace;" +
        "letter-spacing:-.02em;box-shadow:0 10px 30px rgba(17,24,39,.25);opacity:0;" +
        "transform:translate(-50%,-50%) rotate(-4deg)",
      document.body
    );
    el.setAttribute("aria-hidden", "true");
    var text = mk("span", "", el);
    var cursor = mk("span", "display:inline-block;width:.5em;height:1em;margin-left:.05em;background:#fff;vertical-align:-.12em", el);
    var blink = cursor.animate([{ opacity: 1 }, { opacity: 1, offset: 0.5 }, { opacity: 0, offset: 0.5 }, { opacity: 0 }], {
      duration: 600,
      iterations: Infinity,
    });
    var base = "translate(-50%,-50%) ";
    function sleep(ms) { return new Promise(function (r) { setTimeout(r, ms); }); }
    var p = el
      .animate(
        [
          { transform: base + "rotate(-12deg) scale(.2)", opacity: 0 },
          { transform: base + "rotate(-2deg) scale(1.08)", opacity: 1, offset: 0.7 },
          { transform: base + "rotate(-4deg) scale(1)", opacity: 1 },
        ],
        { duration: 450, easing: "cubic-bezier(.2,.8,.3,1)", fill: "forwards" }
      )
      .finished;
    CAUGHT_LINK.split("").forEach(function (ch) {
      p = p.then(function () { text.textContent += ch; return sleep(45); });
    });
    function cleanup() { blink.cancel(); el.remove(); }
    return p
      .then(function () { return sleep(2500); })
      .then(function () {
        return el.animate(
          [
            { transform: base + "rotate(-4deg) scale(1)", opacity: 1, filter: "blur(0)" },
            { transform: base + "rotate(-3deg) scale(1.06)", opacity: 0, filter: "blur(10px)" },
          ],
          { duration: 900, easing: "ease-in", fill: "forwards" }
        ).finished;
      })
      .then(cleanup, cleanup);
  }

  function makeCaughtPrefix() {
    var h = new Date().getHours();
    var timeOfDay = h < 12 ? "Good morning" : h < 18 ? "Good afternoon" : "Good evening";
    var pool = GREETINGS.concat(timeOfDay);
    var greeting = pool[Math.floor(Math.random() * pool.length)];
    return greeting + "! You clicked me, come find me — ";
  }

  function mk(tag, css, parent) {
    var n = document.createElement(tag);
    if (css) n.style.cssText = css;
    if (parent) parent.appendChild(n);
    return n;
  }

  // Hand-drawn comic speech bubble (port of GoatSpeechBubble.tsx).
  function buildBubble(parent, text, link) {
    var b = mk(
      "div",
      (phoneBox
        ? "position:absolute;bottom:100%;left:" + phoneBox.left + "px;margin-bottom:1.5rem;box-sizing:border-box;" +
          "width:" + phoneBox.width + "px;padding:.75rem 1rem;text-align:left;font-weight:500;" +
          "font-size:1.125rem;line-height:1.25;"
        : "position:absolute;bottom:100%;right:0;margin-bottom:2rem;box-sizing:border-box;" +
          "width:26rem;max-width:85vw;padding:1rem 1.25rem;text-align:left;font-weight:500;" +
          "font-size:1.875rem;line-height:1.25;") + "font-family:" + BUBBLE_FONT + ";color:" + PINK + ";" +
        "background:#fff;border:4px solid " + INK + ";box-shadow:0 6px 18px rgba(17,24,39,0.18);" +
        "border-radius:26px 30px 24px 32px / 30px 24px 32px 26px;transform:rotate(-1deg);" +
        "pointer-events:auto;cursor:pointer",
      parent
    );
    b.appendChild(document.createTextNode(text));
    if (link) {
      var a = mk("span", "color:" + PINK + ";text-decoration:underline", b);
      a.textContent = link;
    }
    var tail = mk("span", "position:absolute;top:calc(100% - 2px);" + (phoneBox ? "left:" + phoneBox.tail + "px" : "right:44px"), b);
    tail.innerHTML =
      '<svg width="40" height="34" viewBox="0 0 40 34" aria-hidden="true" style="overflow:visible;display:block">' +
      '<path d="' + TAIL_FILL + '" fill="#fff"/>' +
      '<path d="' + TAIL_LINE + '" fill="none" stroke="' + INK + '" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/></svg>';
    var accents = [
      "left:10%;top:-14px;width:58%;height:3px;transform:rotate(0.6deg)",
      "left:72%;top:-12px;width:14px;height:3px;transform:rotate(2deg)",
      "left:-15px;top:12%;width:3px;height:42%;transform:rotate(3deg)",
      "right:-15px;top:55%;width:3px;height:30%;transform:rotate(-6deg)",
    ];
    accents.forEach(function (css) {
      mk("span", "position:absolute;border-radius:9999px;background:" + INK + ";" + css, b).setAttribute("aria-hidden", "true");
    });
    return b;
  }

  function start(btn) {
    if (running) return;
    running = true;
    loadFont();
    GOAT_WIDTH = window.innerWidth < PHONE_MAX ? GOAT_WIDTH_SMALL : 190;
    btn.disabled = true;
    var logo = btn.querySelector("img");
    var logoSrc = logo ? logo.getAttribute("src") : "/assets/images/pink-goat-logo.png";

    var overlay = mk(
      "div",
      "position:fixed;left:0;top:50%;transform:translateY(-50%);z-index:100000;" +
        "pointer-events:none;width:" + GOAT_WIDTH + "px",
      document.body
    );
    overlay.setAttribute("aria-hidden", "true");
    var outer = mk(
      "div",
      "position:relative;width:" + GOAT_WIDTH + "px;will-change:transform;" +
        "transform:translate3d(" + -GOAT_WIDTH + "px,0,0)",
      overlay
    );
    var inner = mk(
      "img",
      "display:block;width:" + GOAT_WIDTH + "px;height:auto;transform-origin:50% 100%;" +
        "will-change:transform;filter:" + GLOW + ";pointer-events:auto;cursor:pointer;max-width:none",
      outer
    );
    inner.src = logoSrc;
    inner.alt = "";

    var bubble = null;
    var caught = false;
    var cancelled = false;
    var sleeper = null; // { timer, reject }
    var dismiss = null;

    function showBubble(text, link) {
      if (bubble) bubble.remove();
      var vwNow = window.innerWidth;
      if (vwNow < PHONE_MAX) {
        var w = Math.min(vwNow - 24, 360);
        var gx = currentX();
        var leftVp = Math.max(12, Math.min(gx + GOAT_WIDTH / 2 - w / 2, vwNow - 12 - w));
        var tail = Math.max(16, Math.min(gx + GOAT_WIDTH / 2 - leftVp - 20, w - 56));
        phoneBox = { left: Math.round(leftVp - gx), width: w, tail: Math.round(tail) };
      } else {
        phoneBox = null;
      }
      bubble = buildBubble(outer, text, link);
      return bubble;
    }
    function removeBubble() {
      if (bubble) bubble.remove();
      bubble = null;
    }

    // A wait that is cut short (rejected) when the goat is clicked.
    function wait(ms) {
      return new Promise(function (resolve, reject) {
        var timer = setTimeout(function () {
          sleeper = null;
          resolve();
        }, ms);
        sleeper = { timer: timer, reject: reject };
      });
    }

    function walkTo(from, to, easing) {
      var duration = Math.max(900, Math.abs(to - from) / WALK_SPEED);
      var steps = Math.max(1, Math.round(duration / 520));
      var bob = inner.animate(
        [
          { transform: "translate3d(0,0,0) rotate(0deg)", easing: "ease-out" },
          { transform: "translate3d(0,-9px,0) rotate(-2.5deg)", offset: 0.25, easing: "ease-in" },
          { transform: "translate3d(0,0,0) rotate(0deg)", offset: 0.5, easing: "ease-out" },
          { transform: "translate3d(0,-9px,0) rotate(2.5deg)", offset: 0.75, easing: "ease-in" },
          { transform: "translate3d(0,0,0) rotate(0deg)" },
        ],
        { duration: duration / steps, iterations: steps }
      );
      var move = outer.animate(
        [
          { transform: "translate3d(" + from + "px,0,0)" },
          { transform: "translate3d(" + to + "px,0,0)" },
        ],
        { duration: duration, easing: easing, fill: "forwards" }
      );
      return move.finished.finally(function () {
        bob.cancel();
      });
    }

    // "Poof": the bubble puffs up and fades while small clouds drift out.
    function poofBubble() {
      var el = bubble;
      if (!el) return Promise.resolve();
      var hostRect = outer.getBoundingClientRect();
      var rect = el.getBoundingClientRect();
      var cx = rect.left - hostRect.left + rect.width / 2;
      var cy = rect.top - hostRect.top + rect.height / 2;
      var puffs = [];
      var count = 9;
      for (var i = 0; i < count; i++) {
        var size = 18 + Math.random() * 22;
        var puff = mk(
          "span",
          "position:absolute;left:" + (cx - size / 2) + "px;top:" + (cy - size / 2) + "px;width:" + size +
            "px;height:" + size + "px;border-radius:9999px;background:#fff;border:3px solid " + INK +
            ";pointer-events:none;opacity:0",
          outer
        );
        puffs.push(puff);
        var angle = (i / count) * Math.PI * 2 + Math.random() * 0.5;
        var dist = Math.min(rect.width / 2, 110) * (0.6 + Math.random() * 0.5);
        puff.animate(
          [
            { transform: "translate(0,0) scale(0.3)", opacity: 0.95 },
            {
              transform: "translate(" + Math.cos(angle) * dist + "px," + Math.sin(angle) * dist * 0.7 + "px) scale(1.3)",
              opacity: 0,
            },
          ],
          { duration: 520, easing: "cubic-bezier(0.2,0.7,0.3,1)", fill: "forwards" }
        );
      }
      return el
        .animate(
          [
            { transform: "scale(1)", opacity: 1, filter: "blur(0px)" },
            { transform: "scale(1.12)", opacity: 0.85, filter: "blur(0px)", offset: 0.35 },
            { transform: "scale(1.5)", opacity: 0, filter: "blur(6px)" },
          ],
          { duration: 360, easing: "ease-out", fill: "forwards" }
        )
        .finished.finally(function () {
          setTimeout(function () {
            puffs.forEach(function (p) { p.remove(); });
          }, 560);
        });
    }
    function hideBubble() {
      return poofBubble().then(removeBubble, removeBubble);
    }

    function currentX() {
      return outer.getBoundingClientRect().left;
    }
    function jumpAnim() {
      return inner.animate(
        [
          { transform: "translate3d(0,0,0) scale(1,1)", easing: "ease-out" },
          { transform: "translate3d(0,0,0) scale(1.08,0.9)", offset: 0.15, easing: "cubic-bezier(0.2,0.7,0.3,1)" },
          { transform: "translate3d(0,-" + (window.innerWidth < PHONE_MAX ? 110 : 160) + "px,0) rotate(-8deg) scale(0.96,1.06)", offset: 0.5, easing: "cubic-bezier(0.7,0,0.8,0.3)" },
          { transform: "translate3d(0,0,0) scale(1.1,0.88)", offset: 0.85, easing: "ease-out" },
          { transform: "translate3d(0,0,0) scale(1,1)" },
        ],
        { duration: 1100, iterations: 2 }
      );
    }

    // Clicking Biscuit mid-walk.
    inner.addEventListener("click", function () {
      if (caught) return;
      caught = true;
      var x = outer.getBoundingClientRect().left;
      outer.getAnimations({ subtree: true }).forEach(function (a) { a.cancel(); });
      outer.style.transform = "translate3d(" + x + "px,0,0)";
      if (sleeper) {
        clearTimeout(sleeper.timer);
        var s = sleeper;
        sleeper = null;
        s.reject(new Error("caught"));
      }
      removeBubble();
    });

    function finish() {
      cancelled = true;
      overlay.remove();
      btn.disabled = false;
      running = false;
    }

    var vw = window.innerWidth;
    var middle = vw / 2 - GOAT_WIDTH / 2;
    var rightEdge = vw - GOAT_WIDTH - EDGE_GAP;

    var lookLine = pick(LOOK_LINES);
    var chewLine = pick(CHEW_LINES);
    var stages = [
      // Left edge to the middle.
      function () { return walkTo(currentX(), middle, "cubic-bezier(0.25, 0.1, 0.3, 1)"); },
      // Look-at-me jump.
      function () {
        showBubble(lookLine);
        return wait(3500)
          .then(function () { return jumpAnim().finished; })
          .then(function () { return wait(800); })
          .then(hideBubble);
      },
      // Middle to the right edge.
      function () { return walkTo(currentX(), rightEdge, "ease-in-out"); },
      // Chewing.
      function () {
        showBubble(chewLine);
        return wait(5000).then(hideBubble);
      },
      // Off the screen.
      function () { return walkTo(currentX(), vw + EDGE_GAP, "cubic-bezier(0.5, 0, 0.9, 0.6)"); },
    ];

    function shakeFrames(px, deg, hop) {
      var frames = [];
      for (var i = 0; i < 21; i++) {
        var k = i % 2 ? 1 : -1;
        var amp = i === 20 ? 0 : 1 - i / 28;
        frames.push({
          transform:
            "translate3d(" + k * px * amp + "px," + (i % 2 ? -hop : 0) * amp + "px,0) rotate(" + k * deg * amp +
            "deg) scale(" + (1 + 0.06 * amp * k) + ")",
        });
      }
      return frames;
    }

    // Caught: point to findthepinkgoat.com, then carry on.
    function handleCaught() {
      var b = showBubble(makeCaughtPrefix(), CAUGHT_LINK);
      b.addEventListener("click", function () {
        window.open(CAUGHT_URL, "_blank", "noopener,noreferrer");
        if (dismiss) dismiss();
      });
      var shake = jumpAnim();
      var bubbleShake = b.animate(shakeFrames(9, 5, 12), { duration: 2200, easing: "linear" });
      return new Promise(function (resolve) {
        var timer = setTimeout(resolve, 9000);
        dismiss = function () {
          clearTimeout(timer);
          resolve();
        };
      })
        .then(function () {
          dismiss = null;
          shake.cancel();
          bubbleShake.cancel();
          return hideBubble();
        })
        .then(function () {
          caught = false;
        });
    }

    // Runs the stages in order; if she is caught, resumes where she left off.
    function run(stage) {
      if (cancelled) return Promise.resolve(false);
      if (stage >= stages.length) return Promise.resolve(true); // goat made it off screen
      return stages[stage]().then(
        function () { return run(stage + 1); },
        function () {
          if (!caught) return; // real error: stop quietly
          return handleCaught().then(function () { return run(stage); });
        }
      );
    }

    requestAnimationFrame(function () {
      run(0)
        .then(function (done) { return done ? showBanner() : null; })
        .then(finish, finish);
    });
  }

  document.addEventListener("click", function (e) {
    var btn = e.target.closest && e.target.closest(".pink-goat-btn");
    if (btn) start(btn);
  });
})();
