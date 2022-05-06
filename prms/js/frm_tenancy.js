function frm_tenancy(_action = 'add', data = []) {
  if(data.length == 0 && _action !='add') return;
  var _id;
  var _where = '1<>1';
  var is_owner = data[2] != session_user_id.value;
  var status = data[10];

  params = {
    table: 'tenancy',
    action: _action,
    where: _where,
    callback: window.location.href,
    btn_delete: false
  };

  
  if (_action == 'add') {
    _id = '';
  }
  else {
    _id = data[0];
    params['where'] = 'tenancy_id=' + _id;
    if(status != 'DRAFT') params['action'] = 'view';
  }
  
  params['values'] = {
    tenancy_id: _id,
    tenancy_date: new Date().toISOString().substring(0, 10),
    start_date: new Date().toISOString().substring(0, 10),
  };

  params['attributes'] = {
    property_id: 'required',
    tenancy_date: 'required',
    tenant_id: 'required',
    start_date: 'required',
    end_date: 'required',
    rent_per_month: 'required',
    tenancy_status: 'required',
    tenancy_status: 'readonly'
  };

  params['types'] = {
    tenancy_id: 'hidden',
    tenancy_date: 'date',
    start_date: 'date',
    end_date: 'date',
    rent_per_month: 'currency',
  };

  var psql = 'select property_id, concat(property_number, " - ", property_description) pname from property where 1=1 ';
  var tsql = 'select user_id, concat(user_name, " - ", email) from user where 1=1 ';

  if(is_owner){
    psql += ' AND owner_id = ' + session_user_id.value;
    tsql += ' AND user_id <> ' + session_user_id.value;
  }
  else
    tsql += ' AND user_id = ' + session_user_id.value;

  if(_action=='add')
    psql += " AND property_status = 'AVAILABLE'";
  
  params['dropdowns'] = {
    property_id: psql,
    tenant_id: tsql
  };

  if (_action == 'add') {
    params['values']['tenancy_status'] ='DRAFT';
  } else {

    if (status == 'DRAFT') {
      if (is_owner)
        params['btn_delete'] = true;
      else {
        params['buttons'] = {
          btnAction: { class: 'btn btn-warning  mr-2 mw-90', onclick: 'btnAction("approve")', text: 'Approve' }
        };
        params['scripts'] = ['detail_tenancy']
      }
    }

    if (is_owner && status == 'ACTIVE'){
      params['buttons'] = {
        btnAction: { class: 'btn btn-warning  mr-2 mw-90', onclick: 'btnAction("void")', text: 'Void' }
      }
      params['scripts'] = ['detail_tenancy']
    }

  }

  post('detail.php', params);

}
