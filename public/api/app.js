// Variables Declarations
var baseUrl = `${location.protocol}//${location.host}/`;
var apiEndpoint = `api/`;
// GET a SUNCTUM CSRF
$(document).ready(function () {
  axios
    .get('/sanctum/csrf-cookie')
    .then(response => {
      console.log(response);
    });
});
// GET Function with Axios
function getAllData(endUrl, fctOutput, dataObject = {}) {
  axios
    .get(baseUrl + endUrl, {
      // timeout: 5000,
      params: dataObject,
    })
    .then(res => fctOutput(res.data, dataObject))
    .catch(err => {
      console.log(err);
      fctOutput(err.response.data);
    });
}
// POST Function Axois
function addData(endUrl, dataObject, fctOutput) {
  axios
    .post(baseUrl + endUrl, dataObject)
    .then(res => fctOutput(res.data, dataObject))
    .catch(err => {
      fctOutput(err.response.data);
    });
}
// PUT Function Axois 
function updateData(endUrl, dataObject, fctOutput) {
  axios
    .put(baseUrl + endUrl, dataObject)
    .then(res => fctOutput(res.data))
    .catch(err => {
      fctOutput(err.response.data);
    });
}
// DELETE Function Axois
function deleteData(endUrl, fctOutput) {
  axios
    .delete(baseUrl + endUrl)
    .then(res => fctOutput(res.data))
    .catch(err => {
      fctOutput(err.response.data);
    });
}
// To upload files with Axois
function uploading(endUrl, dataObject, fctOutput) {
  axios({
    method: 'post',
    url: baseUrl + endUrl,
    data: dataObject,
  })
    .then(res => fctOutput(res.data))
    .catch(err => {
      fctOutput(err.response.data);
    });
}
