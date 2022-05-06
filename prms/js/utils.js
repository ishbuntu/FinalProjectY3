// show active tab on refresh
$('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
  localStorage.setItem('activeTab', $(e.target).attr('href'));
});
var activeTab = localStorage.getItem('activeTab');
if (activeTab) {
  $('#myTab a[href="' + activeTab + '"]').tab('show');
}

function post(path, params, method = 'post') {
    const form = document.createElement('form');
    form.method = method;
    form.action = path;
    const hiddenField = document.createElement('input');
    hiddenField.type = 'hidden';
    hiddenField.name = 'params';
    hiddenField.value = JSON.stringify(params);
    form.appendChild(hiddenField);
    document.body.appendChild(form);
    form.submit();
  }
