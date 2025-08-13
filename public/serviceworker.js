var staticCacheName = "pwa-v" + new Date().getTime();
var filesToCache = [
    "/offline",
    "/build/assets/app-BR6m_u6L.css",
    "/build/assets/app-C5x4t17K.js",
    "/manifest.json",
    "/",
    "/build/assets/caricon-D5J9yqkI.png",
    "/images/icons/apple-icon-72x72.png",
    "/images/icons/apple-icon-96x96.png",
    "/images/icons/apple-icon-128x128.png",
    "/images/icons/apple-icon-144x144.png",
    "/images/icons/apple-icon-152x152.png",
    "/images/icons/apple-icon-192x192.png",
    "/images/icons/apple-icon-384x384.png",
    "/images/icons/apple-icon-512x512.png",
];

// Cache on install
self.addEventListener("install", (event) => {
    this.skipWaiting();
    event.waitUntil(
        caches.open(staticCacheName).then((cache) => {
            return cache.addAll(filesToCache);
        })
    );
});

// Clear cache on activate
self.addEventListener("activate", (event) => {
    event.waitUntil(
        caches.keys().then((cacheNames) => {
            return Promise.all(
                cacheNames
                    .filter((cacheName) => cacheName.startsWith("pwa-"))
                    .filter((cacheName) => cacheName !== staticCacheName)
                    .map((cacheName) => caches.delete(cacheName))
            );
        })
    );
});

// Serve from Cache
// self.addEventListener("fetch", (event) => {
//     event.respondWith(
//         caches
//             .match(event.request)
//             .then((response) => {
//                 return response || fetch(event.request);
//             })
//             .catch(() => {
//                 return caches.match("/offline");
//             })
//     );
// });

// Serve from cache if offline
self.addEventListener("fetch", (event) => {
    event.respondWith(
        caches
            .match(event.request)
            .then((response) => {
                return response || fetch(event.request);
            })
            .catch(() => {
                // optional fallback page
                return caches.match("/offline");
            })
    );
});
