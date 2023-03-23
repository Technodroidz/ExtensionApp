browser.runtime.sendMessage({ greeting: "hello" }).then((response) => {
});

browser.runtime.onMessage.addListener((request, sender, sendResponse) => {
});

setInterval(function() {

let currentURL = window.location.href;
let machineid = getMachineId();
console.log(currentURL);
console.log(machineid);
var formdata = new FormData();
formdata.append("url", currentURL);
formdata.append("machineid", machineid);

    
var requestOptions = {
  method: 'POST',
  body: formdata,
  redirect: 'follow'
};
fetch("https://www.younggeeks.co.in/ExtensionAppApi/api/saveurl", requestOptions)
  .then(
         response => response.text()
       )
   .then(
      //  result => console.log(result)
        console.log('History Saved Successfully')
   
   ).catch(
      error => console.log('error', error)
   );

}, 15000);
function getMachineId() {
    let machineId = localStorage.getItem('MachineId');
    if (!machineId) {
        machineId = crypto.randomUUID();
        localStorage.setItem('MachineId', machineId);
    }
    
//    var browserInfo = navigator.userAgent + navigator.language + (new Date()).getTime();
//    var uniqueId = btoa(browserInfo);
//    console.log('My unique identifier is: ' + uniqueId);
//
//
//
//    var uniqueId = localStorage.getItem('myUniqueId');
//
//    // If the unique identifier is not found, generate a new one and store it in local storage
//    if (!uniqueId) {
//        uniqueId = Math.random().toString(36).substr(2, 9);
//        localStorage.setItem('myUniqueId', uniqueId);
//    }
//    console.log('My unique identifier is: ' + uniqueId);
    

    return machineId;
}





