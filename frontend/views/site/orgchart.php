<?php

/**
 * Created by PhpStorm.
 * User: Tanakorn Phompak
 * Date: 24/9/2562
 * Time: 9:36
 */
$this->registerCssFile("@web/css/orgchart.css", [
    'depends' => [\yii\bootstrap\BootstrapAsset::className()],
]);
$imageUrl = 'https://keenthemes.com/metronic/themes/metronic/theme/default/demo7/dist/assets/media/users/300_21.jpg';
?>
<div class="row">
    <div class="col-md-12">
        <div class="centered zoomable">
            <ul class="orgchart">
                <li class="root">
                    <div class="nodecontent">
                        <div class="card">
                            <div class="node-image">
                                <img src="<?= $imageUrl ?>" alt="image" class="img-responsive center-block"/>
                            </div>
                            <div class="node-info">
                                <h2>Ondřej Page Bárta</h2>
                                <p>Student of IT in Czech republic.</p>
                                <p class="hidden">Interested in Web technologies like HTML5, CSS3, JavaScript, PHP, MySQL, etc.</p>
                                <span class="left bottom">tel: 731 366 ***</span>
                                <span class="right bottom">adress: Czech Republic</span>
                            </div>
                        </div>
                    </div>
                    <ul>
                        <li class="node">
                            <div class="nodecontent">
                                <div class="card">
                                    <div class="node-image">
                                        <img src="<?= $imageUrl ?>" alt="image" class="img-responsive center-block"/>
                                    </div>
                                    <div class="node-info">
                                        <h2>Ondřej Page Bárta</h2>
                                        <p>Student of IT in Czech republic.</p>
                                        <p class="hidden">Interested in Web technologies like HTML5, CSS3, JavaScript, PHP, MySQL, etc.</p>
                                        <span class="left bottom">tel: 731 366 ***</span>
                                        <span class="right bottom">adress: Czech Republic</span>
                                    </div>
                                </div>
                            </div>
                            <ul>
                                <li class="vertical">
                                    <div class="nodecontent">
                                        <div class="card">
                                            <div class="node-image">
                                                <img src="<?= $imageUrl ?>" alt="image" class="img-responsive center-block"/>
                                            </div>
                                            <div class="node-info">
                                                <h2>Ondřej Page Bárta</h2>
                                                <p>Student of IT in Czech republic.</p>
                                                <p class="hidden">Interested in Web technologies like HTML5, CSS3, JavaScript, PHP, MySQL, etc.</p>
                                                <span class="left bottom">tel: 731 366 ***</span>
                                                <span class="right bottom">adress: Czech Republic</span>
                                            </div>
                                        </div>
                                    </div>
                                    <ul>
                                        <li class="leaf">
                                            <div class="nodecontent">
                                                <div class="card">
                                                    <div class="node-image">
                                                        <img src="<?= $imageUrl ?>" alt="image" class="img-responsive center-block"/>
                                                    </div>
                                                    <div class="node-info">
                                                        <h2>Ondřej Page Bárta</h2>
                                                        <p>Student of IT in Czech republic.</p>
                                                        <p class="hidden">Interested in Web technologies like HTML5, CSS3, JavaScript, PHP, MySQL, etc.</p>
                                                        <span class="left bottom">tel: 731 366 ***</span>
                                                        <span class="right bottom">adress: Czech Republic</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="leaf">
                                            <div class="nodecontent">
                                                <div class="card">
                                                    <div class="node-image">
                                                        <img src="<?= $imageUrl ?>" alt="image" class="img-responsive center-block"/>
                                                    </div>
                                                    <div class="node-info">
                                                        <h2>Ondřej Page Bárta</h2>
                                                        <p>Student of IT in Czech republic.</p>
                                                        <p class="hidden">Interested in Web technologies like HTML5, CSS3, JavaScript, PHP, MySQL, etc.</p>
                                                        <span class="left bottom">tel: 731 366 ***</span>
                                                        <span class="right bottom">adress: Czech Republic</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </li>
                                <li class="leaf">
                                    <div class="nodecontent">
                                        <div class="card">
                                            <div class="node-image">
                                                <img src="<?= $imageUrl ?>" alt="image" class="img-responsive center-block"/>
                                            </div>
                                            <div class="node-info">
                                                <h2>Ondřej Page Bárta</h2>
                                                <p>Student of IT in Czech republic.</p>
                                                <p class="hidden">Interested in Web technologies like HTML5, CSS3, JavaScript, PHP, MySQL, etc.</p>
                                                <span class="left bottom">tel: 731 366 ***</span>
                                                <span class="right bottom">adress: Czech Republic</span>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </li>
                        <li class="vertical">
                            <div class="nodecontent">
                                <div class="card">
                                    <div class="node-image">
                                        <img src="<?= $imageUrl ?>" alt="image" class="img-responsive center-block"/>
                                    </div>
                                    <div class="node-info">
                                        <h2>Ondřej Page Bárta</h2>
                                        <p>Student of IT in Czech republic.</p>
                                        <p class="hidden">Interested in Web technologies like HTML5, CSS3, JavaScript, PHP, MySQL, etc.</p>
                                        <span class="left bottom">tel: 731 366 ***</span>
                                        <span class="right bottom">adress: Czech Republic</span>
                                    </div>
                                </div>
                            </div>
                            <ul>
                                <li class="leaf">
                                    <div class="nodecontent">
                                        <div class="card">
                                            <div class="node-image">
                                                <img src="<?= $imageUrl ?>" alt="image" class="img-responsive center-block"/>
                                            </div>
                                            <div class="node-info">
                                                <h2>Ondřej Page Bárta</h2>
                                                <p>Student of IT in Czech republic.</p>
                                                <p class="hidden">Interested in Web technologies like HTML5, CSS3, JavaScript, PHP, MySQL, etc.</p>
                                                <span class="left bottom">tel: 731 366 ***</span>
                                                <span class="right bottom">adress: Czech Republic</span>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="leaf">
                                    <div class="nodecontent">
                                        <div class="card">
                                            <div class="node-image">
                                                <img src="<?= $imageUrl ?>" alt="image" class="img-responsive center-block"/>
                                            </div>
                                            <div class="node-info">
                                                <h2>Ondřej Page Bárta</h2>
                                                <p>Student of IT in Czech republic.</p>
                                                <p class="hidden">Interested in Web technologies like HTML5, CSS3, JavaScript, PHP, MySQL, etc.</p>
                                                <span class="left bottom">tel: 731 366 ***</span>
                                                <span class="right bottom">adress: Czech Republic</span>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </li>
                        <li class="vertical">
                            <div class="nodecontent">
                                <div class="card">
                                    <div class="node-image">
                                        <img src="<?= $imageUrl ?>" alt="image" class="img-responsive center-block"/>
                                    </div>
                                    <div class="node-info">
                                        <h2>Ondřej Page Bárta</h2>
                                        <p>Student of IT in Czech republic.</p>
                                        <p class="hidden">Interested in Web technologies like HTML5, CSS3, JavaScript, PHP, MySQL, etc.</p>
                                        <span class="left bottom">tel: 731 366 ***</span>
                                        <span class="right bottom">adress: Czech Republic</span>
                                    </div>
                                </div>
                            </div>
                            <ul>
                                <li class="leaf">
                                    <div class="nodecontent">
                                        <div class="card">
                                            <div class="node-image">
                                                <img src="<?= $imageUrl ?>" alt="image" class="img-responsive center-block"/>
                                            </div>
                                            <div class="node-info">
                                                <h2>Ondřej Page Bárta</h2>
                                                <p>Student of IT in Czech republic.</p>
                                                <p class="hidden">Interested in Web technologies like HTML5, CSS3, JavaScript, PHP, MySQL, etc.</p>
                                                <span class="left bottom">tel: 731 366 ***</span>
                                                <span class="right bottom">adress: Czech Republic</span>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="leaf">
                                    <div class="nodecontent">
                                        <div class="card">
                                            <div class="node-image">
                                                <img src="<?= $imageUrl ?>" alt="image" class="img-responsive center-block"/>
                                            </div>
                                            <div class="node-info">
                                                <h2>Ondřej Page Bárta</h2>
                                                <p>Student of IT in Czech republic.</p>
                                                <p class="hidden">Interested in Web technologies like HTML5, CSS3, JavaScript, PHP, MySQL, etc.</p>
                                                <span class="left bottom">tel: 731 366 ***</span>
                                                <span class="right bottom">adress: Czech Republic</span>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </li>
                        <li class="vertical">
                            <div class="nodecontent">
                                <div class="card">
                                    <div class="node-image">
                                        <img src="<?= $imageUrl ?>" alt="image" class="img-responsive center-block"/>
                                    </div>
                                    <div class="node-info">
                                        <h2>Ondřej Page Bárta</h2>
                                        <p>Student of IT in Czech republic.</p>
                                        <p class="hidden">Interested in Web technologies like HTML5, CSS3, JavaScript, PHP, MySQL, etc.</p>
                                        <span class="left bottom">tel: 731 366 ***</span>
                                        <span class="right bottom">adress: Czech Republic</span>
                                    </div>
                                </div>
                            </div>
                            <ul>
                                <li class="leaf">
                                    <div class="nodecontent">
                                        <div class="card">
                                            <div class="node-image">
                                                <img src="<?= $imageUrl ?>" alt="image" class="img-responsive center-block"/>
                                            </div>
                                            <div class="node-info">
                                                <h2>Ondřej Page Bárta</h2>
                                                <p>Student of IT in Czech republic.</p>
                                                <p class="hidden">Interested in Web technologies like HTML5, CSS3, JavaScript, PHP, MySQL, etc.</p>
                                                <span class="left bottom">tel: 731 366 ***</span>
                                                <span class="right bottom">adress: Czech Republic</span>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="leaf">
                                    <div class="nodecontent">
                                        <div class="card">
                                            <div class="node-image">
                                                <img src="<?= $imageUrl ?>" alt="image" class="img-responsive center-block"/>
                                            </div>
                                            <div class="node-info">
                                                <h2>Ondřej Page Bárta</h2>
                                                <p>Student of IT in Czech republic.</p>
                                                <p class="hidden">Interested in Web technologies like HTML5, CSS3, JavaScript, PHP, MySQL, etc.</p>
                                                <span class="left bottom">tel: 731 366 ***</span>
                                                <span class="right bottom">adress: Czech Republic</span>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="leaf">
                                    <div class="nodecontent">
                                        <div class="card">
                                            <div class="node-image">
                                                <img src="<?= $imageUrl ?>" alt="image" class="img-responsive center-block"/>
                                            </div>
                                            <div class="node-info">
                                                <h2>Ondřej Page Bárta</h2>
                                                <p>Student of IT in Czech republic.</p>
                                                <p class="hidden">Interested in Web technologies like HTML5, CSS3, JavaScript, PHP, MySQL, etc.</p>
                                                <span class="left bottom">tel: 731 366 ***</span>
                                                <span class="right bottom">adress: Czech Republic</span>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="leaf">
                                    <div class="nodecontent">
                                        <div class="card">
                                            <div class="node-image">
                                                <img src="<?= $imageUrl ?>" alt="image" class="img-responsive center-block"/>
                                            </div>
                                            <div class="node-info">
                                                <h2>Ondřej Page Bárta</h2>
                                                <p>Student of IT in Czech republic.</p>
                                                <p class="hidden">Interested in Web technologies like HTML5, CSS3, JavaScript, PHP, MySQL, etc.</p>
                                                <span class="left bottom">tel: 731 366 ***</span>
                                                <span class="right bottom">adress: Czech Republic</span>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>
<?php
$this->registerJsFile(
    'https://www.gstatic.com/firebasejs/6.6.2/firebase-app.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
$this->registerJsFile(
    'https://www.gstatic.com/firebasejs/6.6.1/firebase-database.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
$this->registerJsFile(
    'https://www.gstatic.com/firebasejs/6.6.1/firebase-auth.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
$this->registerJsFile(
    '@web/js/panzoom.min.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
$this->registerJs(<<<JS
var element = document.querySelector('.zoomable')
panzoom(element);

// Your web app's Firebase configuration
var firebaseConfig = {
    apiKey: "AIzaSyBh6T-aX8sHUK0NgJferQ5OQzQP9PCjyso",
    authDomain: "react-my-burger-a569b.firebaseapp.com",
    databaseURL: "https://react-my-burger-a569b.firebaseio.com",
    projectId: "react-my-burger-a569b",
    storageBucket: "react-my-burger-a569b.appspot.com",
    messagingSenderId: "528144308973",
    appId: "1:528144308973:web:acf4f70fad4178236e4ae4"
};
  // Initialize Firebase
const app1 = firebase.initializeApp(firebaseConfig);
var database = firebase.database();
var ordersRef = database.ref('orders');
// ordersRef.on('value', function(snapshot) {
//     snapshot.forEach(function(childSnapshot) {
//       var childData = childSnapshot.val();
//       console.log(childSnapshot)
//       console.log(childData)
//     });
// });
ordersRef.on('value', function(snapshot) {
  console.log(snapshot.val())
});
// firebase.auth().signInWithEmailAndPassword('test2@test2.com', '123456').catch(function(error) {
//   // Handle Errors here.
//   var errorCode = error.code;
//   var errorMessage = error.message;
//   console.log(errorMessage)
//   // ...
// });
// firebase.auth().onAuthStateChanged(function(user) {
//   if (user) {
//     console.log(user)
//     // User is signed in.
//     var displayName = user.displayName;
//     var email = user.email;
//     var emailVerified = user.emailVerified;
//     var photoURL = user.photoURL;
//     var isAnonymous = user.isAnonymous;
//     var uid = user.uid;
//     var providerData = user.providerData;
//     var ordersRef = firebase.database().ref('orders');
//     ordersRef.on('value', function(snapshot) {
//         snapshot.forEach(function(childSnapshot) {
//           var childData = childSnapshot.val();
//           console.log(childData)
//         });
//     });
//     // ...
//   } else {
//     // User is signed out.
//     // ...
//   }
// });
// panzoom(element, {
//   maxZoom: 1,
//   minZoom: 0.1
// }).zoomAbs(
//   300, // initial x position
//   1, // initial y position
//   0.7  // initial zoom 
// );
JS
);
?>