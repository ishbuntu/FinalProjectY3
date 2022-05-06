function frm_property(_action = 'add', _id = '') {
    
    var _where = _action == 'add' ? '1<>1' : 'property_id=' + _id;
    
    params = {
      table: 'property',
      action: _action,
      where: _where,
      callback: window.location.href,
    };

    params['values'] = {
      property_id: _id,
      owner_id: session_user_id.value,
    };

    params['attributes'] = {
      owner_id: 'required',
      property_type_id: 'required',
      property_description: 'required',
      city_id: 'required',
      property_status: 'required'
    };
    
    params['types'] = {
      owner_id: 'hidden',
      property_id : 'hidden',
      property_sqft: 'number',
      rent_per_month: 'currency',
    };
    
    params['dropdowns'] = {
      city_id : 'select city_id, concat(city_name, ", ", country_code) from city',
      property_type_id : 'select * from property_type',
      property_status: 'enum.property'
    };

    post('detail.php', params);

  }
