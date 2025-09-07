importScripts('https://www.gstatic.com/firebasejs/9.6.10/firebase-app-compat.js');
importScripts('https://www.gstatic.com/firebasejs/9.6.10/firebase-messaging-compat.js');

// Your web app's Firebase configuration

 // Init Firebase
    firebase.initializeApp({
        apiKey: "AIzaSyDG-CaKhfYL4OwMRPyrFqxZWo1g5b-3Lpk",
        authDomain: "product-selling-app-a75ce.firebaseapp.com",
        projectId: "product-selling-app-a75ce",
        storageBucket: "product-selling-app-a75ce.firebasestorage.app",
        messagingSenderId: "1051996487253",
        appId: "1:1051996487253:web:b15711bd71a7f702c61edc",
    });

    const messaging = firebase.messaging();

    messaging.onBackgroundMessage(function(payload) {
      console.log('[firebase-messaging-sw.js] Received background message ', payload);
        // Customize notification here
        const notificationTitle = payload.notification.title;
        const notificationOptions = {
          body: payload.notification.body,
          icon: '/firebase-logo.png'
        };
        self.registration.showNotification(notificationTitle,
            notificationOptions);
    });
