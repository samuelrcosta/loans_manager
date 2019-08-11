'use strict';

self.addEventListener('push', function(event) {
  console.log('[Service Worker] Push Received.');
  console.log(`[Service Worker] Push had this data: "${event.data.text()}"`);

  let data = JSON.parse(event.data.text());

  const title = data.title;
  let options = {
    body: data.body,
    icon: data.icon,
    badge: data.badge,
    data: data
  };

  if(data.image){
    options.image = data.image;
  }

  event.waitUntil(self.registration.showNotification(title, options));
});

self.addEventListener('notificationclick', function(event) {
  console.log('[Service Worker] Notification click Received.');

  let data = event.notification.data;

  console.log(event.notification);

  event.notification.close();

  if(data.uri){
    event.waitUntil(
      clients.openWindow(data.uri)
    );
  }
});