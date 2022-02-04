# Api for security / monitoring companies

## An api for security / monitoring persons and vehicles entering and leaving facilities. Very cusomizable.

### Endpoints:

#### Authentication routes:

 - Register user: `api/register`, method is `POST`. Has these fields: name, email, password, password_confirmation.

 - Login user: `api/login`, method is `POST`. Has these fields: email and password.

#### Vehicle endpoints: 

 - List vehicles: `list_vehicles`, method is `GET` with optional parameters of type of vehicle and work organization that vehicles belongs to. If entered, these optional parameters narrow down on query. If not, it gives away all vehicles with description of their types and working organizations they belong to.

 Example:
 ```
    {
        "type": "truck",
        "workOrg": "Alpha Trucking Co."
    }
```

 - Create a vehicle: `create_vehicle`, method is `POST` with parameters like registration number which is basically string of numbers of whatever format, an dedicated type(id) of that vehicle that draws values from another table and id that determines which organization it belongs to.

 Example: 
 ```
 {
    "registration": "Kamion2",
    "vehicle_type_id": 1,
    "workOrg": 1
}
```

- Show vehicle: `show_vehicle`, method is `GET` with single parameter of vehicle `id`. This display single vehicle. 

Example:
```
{
    "id": 14
}
```

- Update vehicle: `update_vehicle`, method is `PATCH` with two optional parameters and `id` which is needed to determine which vehicle info needs to be updated.

Example:
```
{
    "id": 14,
    "registration": "8787x",
    "workOrg": 1
}
```

 - Delete vehicle: `delete_vehicle`, method is `DELETE` with required `id` to know which record of vehicle needs to be removed.

Example:
```
    {
        "id": 14
    }
```

#### Work organization endpoints:

 - Create work organization: `create_work_organizations`, method is `POST` with single parameter `name` which is what it says, name of organizaton.

Example:
```
    {
        "name": "Alpha Trucking Co."
    }
```

 - List work organizations: `list_work_organizations`, method is `GET` without parameters.

 - Show work organization: `show_work_organization`, method is `GET` with single parameter of `id` for getting specific organization.

 Example:
 ```
    {
        "id": 1
    }
```

 - Update work organization: `update_work_organization`, method is `PATCH` with two semi optional parameters and one required(id).

 Example:
 ```
 {
    "id": 1,
    "name": "Alpha",
    "sec_id": 1
}
```

 - Delete work organization: `delete_work_organization`, method is `DELETE` with required parameter of `id`. It's same as any other delition.

#### Employees endpoints:

 - Create employee: `create_employee`, method is `POST`. This is little bit different. It also got an avatar which is basically an image which is uploaded for particular employee. Apart from that it also have an, `lastName`, `firstName`, `work_org_id`, `sec_id` fields. Last mentioned is `id` of security official who entered his info.

 - List employees: `list_employees`, method is `GET` without parameters.

 - Show employee: `show_employee`, method is `GET` with single parameter of `id`. It lists single employee.

 Example:
 ```
    {
        "id": 1
    }
```

 - Update employee: `update_employee`, method is `PATCH` with same set of parameters like creating, but with added `id` for existing employee.

 - Delete employee: `delete_employee`, method is `DELETE` with single parameter of `id`. Same as previous.

#### Delivery endpoints:

 - Create delivery: `create_delivery`, method is `POST` with numerous parameters. 

 Example:
 ```
    {
        "load_place": "Smederevo1",
        "unload_place": "Aranđelovac1",
        "comment": "isporuka",
        "time_in": "06:24",
        "time_out": "07:22",
        "vehicles": {
            "truck_id": 1,
            "cistern_id": 2
        },
        "delivery_notes": {
            "num1": 67854654,
            "num2": 24566784
        },
        "operator_id": 1,
        "sec_id": 1
    }
 ```
"time_out" and "time_in" parameters are when vehicle passed the gate, make their delivery and and came back.
"delivery_notes" are notes for specific delivery. Can be anything.

 - List deliveries: `list_deliveries`, method is `GET` without parameters. List all deliveries.

 - Show delivery: `show_delivery`, method is `GET` with single parameter of `id` for getting specific delivery.

 Example:
 ```
     {
        "id": 2
     }
 ```

 - Update delivery: `update_delivery`, method is `PATCH` with parameters exactly as creating, but also with addionional one, an `id` which serves to identify which delivery record needs to be updated.

 Example:
 ```
 {
    "id": 1,
    "load_place": "Smederevo2",
    "unload_place": "Aranđelovac1",
    "comment": "isporuka",
    "time_in": "06:24",
    "time_out": "07:22",
    "vehicles": {
        "truck_id": 1,
        "cistern_id": 2
    },
    "delivery_notes": {
        "num1": 67854654,
        "num2": 24566784
    },
    "operator_id": 1,
    "sec_id": 1
 }
 ```

 - Delete delivery: `delete_delivery`, method is `DELETE` with `id` to identify which one to delete.

 Example:
 ```
    {
        "id": 1
    }
 ```

#### Special permissions endpoints:

 - Create special permission: `create_special_permissions`, method is `POST` with two fields, `permission_name` and `permission_description` which both serve as additional explanation to specific deliveries.

 Example:
 ```
    {
        "permission_name": "permission2",
        "permission_description": "druga permisija"
    }
 ```

 - List special permissions: `list_special_permissions`, method is `GET` without parameters.

 - Show special permissions: `show_special_permissions`, method is `GET` with `id` for identifying specific one.

 Example: 
 ```
    {
        "id": 1
    }
 ```

 - Update special permission: `update_special_permissions`, method is `PATCH` with two fields and `id` for identifying which one.

 Example:
 ```
    {
        "id": 1,
        "permission_name": "permission1",
        "permission_description": "xxx"
    }
 ```

 - Delete special permission: `delete_special_permissions`, method is `DELETE` with an `id` of one.

 Example:
 ```
    {
        "id": 1
    }
 ```

#### Custom reports endpoints:

 - Get models: `getModels`, method is `GET` without parameters. Shows all available models. 

 - Get vehicles: `vehicles`, methos is `GET` with several parameters for query filtering. `start_date` from which date you should start your query( it checks updated_at), `end_date` which is another border date. `vehicle_id` which is optional, if ommited, it will lookup for all vehicles. `vehicle` is array type parameter. It can contain `user`, `type` and `workOrganization` which serves to add additional(optional) info on vehicle.

 Example:
 ```
    {
        "start_date": "17/07/2021",
        "end_date": "30/07/2021",
        "vehicle_id": 1,
        "vehicle": [
            "user",
            "type",
            "workOrganization"
        ]
    }
 ```

 - Get deliveries: `deliveries`, method is `GET` with several parameters, `start_date` from which date you should start your query( it checks updated_at), `end_date` which is another border date. `delivery` which is array type parameter. It can contain `operator` i.e. employee, `enteredBy` which is what security officer entered it in system and `complement` which is basically when truck + cistern go together.

 Example:
 ```
    {
        "start_date": "17/07/2021",
        "end_date": "30/01/2022",
        "delivery": [
            "operator",
            "enteredBy",
            "complement"
        ]
    }
 ```

- Get employees: `employees`, method is `GET` with several parameters. Almost as same as previous, but it's array parameter is `employee` with it's additional info, `work_organization`, `enteredBy` and `deliveries`.

 Example:
 ```
     {
         "start_date": "17/07/2021",
         "end_date": "30/01/2022",
         "employee": [
             "work_organization",
             "enteredBy",
             "deliveries"
         ]
     }
 ```

 - Get users i.e. security officers: `users`, method is `GET`. It also have several parameters and it only differs in it's array one.
 `user` which can contain `role`, `vehicles`, `deliveries`, `complement`, `delivery_details`, `special_permissions` and `employees`.

 Example:
 ```
    {
    "start_date": "17/07/2021",
    "end_date": "30/01/2022",
    "user": [
        "role",
        "vehicles",
        "deliveries",
        "complement",
        "delivery_details",
        "special_permissions",
        "employees"
    ]
 }
```

#### Not mention tables

Tables such: `vehicle_pivot` are for entering types of vehicles and `delivery_details` which connects which security officer entered which delivery info.

 - Get all vehicle types: `list_vehicle_pivot`, method is `GET` without parameters.

 - Create vehicle type: `create_vehicle_pivot`, method is `POST` with single parameter, `name`.

 Example:
 ```
    {
        "name": test1
    }
 ```

 - Show vehicle type: `show_vehicle_pivot`, method is `GET` with single `id` parameter.

 Example:
 ```
    {
        "id": 3
    }
 ```

 - Update vehicle type: `update_vehicle_pivot`, method is `PATCH` with two parameters, `id` and `name`. First one is required.

 Example:
 ```
    {
        "id": 3,
        "name": "test123"
    }
 ```
 
 - Delete vehicle type: `delete_vehicle_pivot`, method is `DELETE` with `id` as parameter.

  Example:
 ```
    {
        "id": 3
    }
 ```
  All of endpoints have this header:

 ```
    'Content-Type': 'application/json',
    "Accept": 'application/json',
    "Authorization": "Bearer " + auth.access_token

```