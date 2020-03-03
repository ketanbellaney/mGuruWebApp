
const version = "0.1";
const cacheName = `mguru-${version}`;
self.addEventListener('install', e => {
  const timeStamp = Date.now();
  e.waitUntil(
    caches.open(cacheName).then(cache => {
      return cache.addAll([
        `/`,
        `/stories/books`,
        `/webapp_asset/images/logo.png`,
        `/webapp_asset/css/animate.css`,
        `/webapp_asset/css/icomoon.css`,
        `/webapp_asset/css/bootstrap.css`,
        `/webapp_asset/css/style_web.css`,
        `/webapp_asset/css/jquery-ui.min.css`,
        `/webapp_asset/js/modernizr-2.6.2.min.js`,
        `/webapp_asset/js/respond.min.js`,
        `/webapp_asset/images/logo.png`,
        `/webapp_asset/images/fb_1.svg`,
        `/webapp_asset/images/popup_close_1.svg`,
        `/webapp_asset/images/motu_6_without_shadow_1.svg`,
        `/webapp_asset/images/motu_shadhow_1.svg`,
        `/webapp_asset/js/jquery.min.js`,
        `/webapp_asset/js/jquery.easing.1.3.js`,
        `/webapp_asset/js/bootstrap.min.js`,
        `/webapp_asset/js/jquery.waypoints.min.js`,
        `/webapp_asset/js/jquery-ui.min.js`,
        `/webapp_asset/js/main.js`,
        `/webapp_asset/js/recorderWorker.js`,
        `/webapp_asset/js/recorder.js`,
        `/webapp_asset/js/recordLive.js`,
        `/webapp_asset/js/circle-progress.min.js`
      ])
          .then(() => self.skipWaiting());
    })
  );
});

self.addEventListener('activate', event => {
  event.waitUntil(self.clients.claim());
});

self.addEventListener('fetch', event => {
  event.respondWith(
    caches.open(cacheName)
      .then(cache => cache.match(event.request, {ignoreSearch: true}))
      .then(response => {
      return response || fetch(event.request);
    })
  );
});
