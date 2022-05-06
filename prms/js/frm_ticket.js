function frm_ticket(_action = 'add', _id = '') {
  
  var _where = _action == 'add' ? '1<>1' : 'ticket_id = ' + _id;

  params = {
    table: 'ticket',
    action: _action,
    where: _where,
    callback: window.location.href,
    btn_delete: false
  };
    
  params['values'] = {
    ticket_id: _id
  }

  params['attributes'] = {
    ticket_date : 'required', 
    tenancy_id: 'required',
    category_id : 'required', 
    ticket_text : 'required', 
  };
  
  params['types'] = {
    ticket_id : 'hidden', 
    ticket_status : 'hidden',
    ticket_date: 'date',
    ticket_text : 'textarea', 
  };
  params['dropdowns'] = {
    category_id: 'select * from category',
    tenancy_id : 'select tenancy_id, concat(property_number, " - " , property_description) from tenancy join property using(property_id) where tenant_id = ' + session_user_id.value
  }

  params['divsizes'] = {
    ticket_text: 12
  }

  if (_action == 'add') {
    params['values'] = {
      ticket_id: '',
      ticket_date: new Date().toISOString().substring(0, 10),
      ticket_status: 'OPEN'
    };
  }

  post('detail.php', params);

}
