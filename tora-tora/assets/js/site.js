(function () {
  "use strict";

  var panels = Array.prototype.slice.call(document.querySelectorAll(".panel"));
  var navLinks = Array.prototype.slice.call(document.querySelectorAll(".nav-link[data-target]"));
  var navToggle = document.querySelector(".nav-toggle");
  var overlayClose = document.querySelector(".overlay-close");
  var overlayMenu = document.querySelector(".overlay-menu");
  var menuTabs = Array.prototype.slice.call(document.querySelectorAll(".menu-tab"));
  var prefersReducedMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches;
  var activePanel = null;
  var activeModal = null;
  var modalTrigger = null;
  var activeMenuSlug = "";

  function validPanel(id) {
    return panels.some(function (panel) { return panel.id === id; });
  }

  function parseHash() {
    var id = window.location.hash.replace(/^#/, "");
    if (id === "story") id = "about";
    if (id.indexOf("menu-") === 0) {
      return { panel: "menu", menu: id.slice(5) };
    }
    if (id === "menu") {
      return { panel: "menu", menu: firstMenuSlug() };
    }
    return { panel: validPanel(id) ? id : "home", menu: "" };
  }

  function firstMenuSlug() {
    return menuTabs.length ? (menuTabs[0].getAttribute("data-menu-slug") || "") : "";
  }

  function hashFor(panelId, menuSlug) {
    if (panelId === "menu") {
      return menuSlug ? "#menu-" + menuSlug : "#menu";
    }
    return "#" + panelId;
  }

  function setNavOpen(open) {
    document.body.classList.toggle("nav-open", open);
    if (navToggle) {
      navToggle.setAttribute("aria-expanded", String(open));
      navToggle.setAttribute("aria-label", open ? "Close menu" : "Open menu");
    }
    if (overlayMenu) {
      overlayMenu.setAttribute("aria-hidden", String(!open));
      if (open) {
        var firstLink = overlayMenu.querySelector("a");
        if (firstLink) window.setTimeout(function () { firstLink.focus(); }, prefersReducedMotion ? 0 : 180);
      }
    }
    var main = document.getElementById("main-content");
    if (main) main.setAttribute("aria-hidden", String(open));
  }

  function showMenuTab(slug) {
    if (!menuTabs.length) return;
    if (!slug || !document.querySelector('.menu-tab[data-menu-slug="' + slug + '"]')) {
      slug = firstMenuSlug();
    }
    activeMenuSlug = slug;
    menuTabs.forEach(function (tab) {
      var selected = tab.getAttribute("data-menu-slug") === slug;
      tab.classList.toggle("is-active", selected);
      tab.setAttribute("aria-selected", String(selected));
    });
    document.querySelectorAll(".menu-tab-panel").forEach(function (panel) {
      var selected = panel.getAttribute("data-menu-slug") === slug;
      panel.classList.toggle("is-active", selected);
      if (selected) panel.removeAttribute("hidden");
      else panel.setAttribute("hidden", "");
    });
  }

  function applyTheme(panel) {
    var theme = panel.getAttribute("data-theme") || "light";
    document.body.classList.toggle("light-panel", theme === "light" || theme === "pattern");
    document.body.classList.toggle("blue-panel", theme === "blue");
    document.body.classList.toggle("dark-panel", theme === "pattern" || theme === "blue");
    document.body.classList.toggle("pattern-panel", theme === "pattern");
    document.body.classList.toggle("about-panel", panel.id === "about");
    document.body.classList.toggle("gallery-view", panel.id === "gallery");
    document.body.classList.toggle("contact-view", panel.id === "contact");
  }

  function showPanel(id, menuSlug, updateHistory, moveFocus) {
    if (!validPanel(id)) id = "home";
    var next = document.getElementById(id);
    if (!next) return;

    if (id === "menu") showMenuTab(menuSlug || firstMenuSlug());

    panels.forEach(function (panel) {
      var selected = panel === next;
      panel.classList.toggle("is-active", selected);
      panel.setAttribute("aria-hidden", String(!selected));
    });

    navLinks.forEach(function (link) {
      var selected = link.getAttribute("data-target") === id;
      link.classList.toggle("is-active", selected);
      if (selected) link.setAttribute("aria-current", "page");
      else link.removeAttribute("aria-current");
    });

    activePanel = next;
    document.body.dataset.panel = id;
    applyTheme(next);
    setNavOpen(false);
    window.scrollTo(0, 0);

    var scroller = next.querySelector(".panel-scroll");
    if (scroller) {
      scroller.scrollTop = 0;
    }

    var nextHash = hashFor(id, id === "menu" ? activeMenuSlug : "");
    if (updateHistory && window.location.hash !== nextHash) {
      history.pushState({ panel: id, menu: activeMenuSlug }, "", nextHash);
    }

    if (moveFocus) {
      var heading = next.querySelector("h1, h2");
      if (heading) {
        heading.setAttribute("tabindex", "-1");
        window.setTimeout(function () {
          heading.focus({ preventScroll: true });
          heading.addEventListener("blur", function () { heading.removeAttribute("tabindex"); }, { once: true });
        }, prefersReducedMotion ? 0 : 240);
      }
    }
  }

  function focusableElements(container) {
    return Array.prototype.slice.call(container.querySelectorAll(
      'a[href], button:not([disabled]), input:not([disabled]), select:not([disabled]), textarea:not([disabled]), [tabindex]:not([tabindex="-1"])'
    )).filter(function (element) {
      return element.offsetWidth > 0 || element.offsetHeight > 0;
    });
  }

  function trapFocus(event, container) {
    if (event.key !== "Tab") return;
    var elements = focusableElements(container);
    if (!elements.length) return;
    var first = elements[0];
    var last = elements[elements.length - 1];
    if (event.shiftKey && document.activeElement === first) {
      event.preventDefault();
      last.focus();
    } else if (!event.shiftKey && document.activeElement === last) {
      event.preventDefault();
      first.focus();
    }
  }

  function openModal(modal, trigger) {
    if (!modal) return;
    activeModal = modal;
    modalTrigger = trigger || document.activeElement;
    modal.classList.add("is-open");
    modal.setAttribute("aria-hidden", "false");
    document.body.classList.add("modal-open");
    var close = modal.querySelector("[data-modal-close]");
    if (close) close.focus();
  }

  function closeModal() {
    if (!activeModal) return;
    activeModal.classList.remove("is-open");
    activeModal.setAttribute("aria-hidden", "true");
    var galleryImage = activeModal.querySelector(".lightbox-image");
    if (galleryImage) galleryImage.removeAttribute("src");
    document.body.classList.remove("modal-open");
    if (modalTrigger && typeof modalTrigger.focus === "function") modalTrigger.focus();
    activeModal = null;
    modalTrigger = null;
  }

  function toggleNav() {
    setNavOpen(!document.body.classList.contains("nav-open"));
  }

  if (navToggle) navToggle.addEventListener("click", toggleNav);
  if (overlayClose) overlayClose.addEventListener("click", function () { setNavOpen(false); });

  navLinks.forEach(function (link) {
    link.addEventListener("click", function (event) {
      if (!panels.length) return;
      event.preventDefault();
      var target = link.getAttribute("data-target");
      showPanel(target, target === "menu" ? firstMenuSlug() : "", true, true);
    });
  });

  menuTabs.forEach(function (tab) {
    tab.addEventListener("click", function () {
      var slug = tab.getAttribute("data-menu-slug") || "";
      showMenuTab(slug);
      history.pushState({ panel: "menu", menu: slug }, "", hashFor("menu", slug));
    });
  });

  document.querySelectorAll(".gallery-link").forEach(function (button) {
    button.addEventListener("click", function () {
      var modal = document.getElementById("gallery-modal");
      var image = modal ? modal.querySelector(".lightbox-image") : null;
      var preview = button.querySelector("img");
      if (!modal || !image) return;
      image.src = button.getAttribute("data-image") || "";
      image.alt = preview ? preview.alt : "";
      openModal(modal, button);
    });
  });

  document.querySelectorAll("[data-modal-close]").forEach(function (button) {
    button.addEventListener("click", closeModal);
  });

  document.querySelectorAll(".modal").forEach(function (modal) {
    modal.addEventListener("mousedown", function (event) {
      if (event.target === modal) closeModal();
    });
  });

  document.addEventListener("keydown", function (event) {
    if (event.key === "Escape") {
      if (activeModal) closeModal();
      else setNavOpen(false);
      return;
    }
    if (activeModal) trapFocus(event, activeModal);
    else if (document.body.classList.contains("nav-open") && overlayMenu) trapFocus(event, overlayMenu);
  });

  window.addEventListener("popstate", function () {
    var parsed = parseHash();
    showPanel(parsed.panel, parsed.menu, false, false);
  });

  if ("scrollRestoration" in history) {
    history.scrollRestoration = "manual";
  }

  window.addEventListener("hashchange", function () {
    window.scrollTo(0, 0);
  });

  if (panels.length) {
    var initial = parseHash();
    showPanel(initial.panel, initial.menu, false, false);
    window.scrollTo(0, 0);
  }
})();
