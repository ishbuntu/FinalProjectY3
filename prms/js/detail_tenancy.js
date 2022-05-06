function btnAction(action) {
    let newStatus = action == 'approve' ? 'ACTIVE' : 'VOID';
    document.forms[0].tenancy_status.value = newStatus;
    Object.entries(document.forms[0].elements).forEach(x => x[1].disabled = false);
    document.forms[0].submit();
}