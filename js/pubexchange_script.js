(function(w, d, s, id) {
  w.PUBX=w.PUBX || {pub: "{{PUBLICATION_ID}}", discover: {{LINK_DISCOVERY}}, lazy: {{LAZY_LOAD}}};
  var js, pjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id; js.async = true;
  js.src = "https://main.pubexchange.com/loader.min.js";
  pjs.parentNode.insertBefore(js, pjs);
}(window, document, "script", "pubexchange-jssdk"));