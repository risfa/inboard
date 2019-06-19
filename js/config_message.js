

  // Initialize Firebase
  var config = {
    apiKey: "AIzaSyB4t6fhr9LrpqfR4yeoUiK6cxsFHsnGJa0",
    authDomain: "cloudmessage-99601.firebaseapp.com",
    databaseURL: "https://cloudmessage-99601.firebaseio.com",
    projectId: "cloudmessage-99601",
    storageBucket: "cloudmessage-99601.appspot.com",
    messagingSenderId: "810702849098"
  };
  firebase.initializeApp(config);
  // Retrieve Firebase Messaging object.
  const messaging = firebase.messaging();
  // Add the public key generated from the console here.
  // messaging.usePublicVapidKey("BKagOny0KF_2pCJQ3m....moL0ewzQ8rZu");
  messaging.requestPermission().then(function() {
    console.log('Notification permission granted.');
    // TODO(developer): Retrieve an Instance ID token for use with FCM.
    // ...
    if (isTokenSentToServer()) {
      console.log('Token already send ');
    }else{
      getRegToken();
    }
    getRegToken();

  }).catch(function(err) {
    console.log('Unable to get permission to notify.', err);
  });

  function getRegToken(argument){
    // Get Instance ID token. Initially this makes a network call, once retrieved
    // subsequent calls to getToken will return from cache.
    messaging.getToken().then(function(currentToken) {
      if (currentToken) {
        // sendTokenToServer(currentToken);
        // updateUIForPushEnabled(currentToken);
        console.log(currentToken);
        saveToken(currentToken);
        setTokenSentToServer(true);
      } else {
        // Show permission request.
        console.log('No Instance ID token available. Request permission to generate one.');
        // Show permission UI.
        setTokenSentToServer(false);
      }
    }).catch(function(err) {
      console.log('An error occurred while retrieving token. ', err);
      showToken('Error retrieving Instance ID token. ', err);
      setTokenSentToServer(false);
    });
  }

  function setTokenSentToServer(sent) {
    window.localStorage.setItem('sentToServer', sent ? '1' : '0');
  }
  function showToken(currentToken) {
    // Show token in console and UI.
    var tokenElement = document.querySelector('#token');
    tokenElement.textContent = currentToken;
  }
  function isTokenSentToServer() {
    return window.localStorage.getItem('sentToServer') === '1';
  }

  messaging.onMessage(function(payload){
    console.log(payload)

    notificationTitle = payload.data.title;
    notificationOptions = {
      body : payload.data.body,
      icon : payload.data.icon
    };
    var notification = new Notification(notificationTitle,notificationOptions);
    notification.onclick = function(event) {
      event.preventDefault(); // prevent the browser from focusing the Notification's tab
      window.open(payload.data.link, '_blank');
    }

    setTimeout(notification.close.bind(notification), 10000);
  });
