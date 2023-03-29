const BASE_URL = 'https://www.younggeeks.co.in/ExtensionAppApi/api';
setInterval(function() {
let currentURL = window.location.href;
let machineid = getMachineId();
console.log(currentURL);
console.log(machineid);
localStorage.setItem("url", currentURL);

 var formdata = new FormData();
 formdata.append("url", currentURL);
 formdata.append("machineid", machineid);

 var requestOptions = {
   method: 'POST',
   body: formdata,
   redirect: 'follow'
 };

 fetch(`${BASE_URL}/saveurl`, requestOptions)
   .then(
          response => response.text()
        )
    .then(
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
    return machineId;
}     