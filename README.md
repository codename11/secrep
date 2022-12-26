# Api for security / monitoring companies

## An api for security / monitoring persons and vehicles entering and leaving facilities. Very customizable.

### Endpoints:

#### Authentication routes:

 - Register user: `api/register`, method is `POST`. Has these fields: name, email, password, password_confirmation. All of them are required. It's `formData`.

 - Login user: `api/login`, method is `POST`. Has these fields: email and password. All of them are required. It's `formData`.

 - Logout user: `api/logout`, method is `POST`. It doesn't have any fields. It's `formData`.

#### Vehicle endpoints: 

 - List vehicles: `list_vehicles`, method is `GET` with optional parameters of type of vehicle and work organization that vehicles belongs to. If entered, these optional parameters narrow down on query. If not, it gives away all vehicles with description of their types and working organizations they belong to.

 Example:
 ```
    {
        "type": "truck", //Not required
        "workOrg": "Alpha Trucking Co." //Not required
    }
```

 - Create a vehicle: `create_vehicle`, method is `POST` with parameters like registration number which is basically string of numbers of whatever format, an dedicated type(id) of that vehicle that draws values from another table and id that determines which organization it belongs to.

 Example: 
 ```
 {
    "registration": "Kamion2", //Required
    "vehicle_type_id": 1, //Required
    "workOrg": 1 //Not required
}
```

- Show vehicle: `show_vehicle`, method is `GET` with single parameter of vehicle `id`. This display single vehicle. 

Example:
```
{
    "id": 14 //Required
}
```

- Update vehicle: `update_vehicle`, method is `PATCH` with two optional parameters and `id` which is needed to determine which vehicle info needs to be updated.

Example:
```
{
    "id": 14, //Required
    "registration": "8787x", //Required
    "vehicle_type_id": 1 //Not required
    "workOrg": 1 //Not required
}
```

 - Delete vehicle: `delete_vehicle`, method is `DELETE` with required `id` to know which record of vehicle needs to be removed.

Example:
```
    {
        "id": 14 //Required
    }
```

#### Work organization endpoints:

 - Create work organization: `create_work_organizations`, method is `POST` with single parameter `name` which is what it says, name of organizaton.

Example:
```
    {
        "name": "Alpha Trucking Co." //Required
    }
```

 - List work organizations: `list_work_organizations`, method is `GET` without parameters.

 - Show work organization: `show_work_organization`, method is `GET` with single parameter of `id` for getting specific organization.

 Example:
 ```
    {
        "id": 1 //Required
    }
```

 - Update work organization: `update_work_organization`, method is `PATCH` with `id` of workOrg and it's `name` and `sec_id`.

 Example:
 ```
 {
    "id": 1, //Required
    "name": "Alpha", //Required
    "sec_id": 1 //Required
 }
```

 - Delete work organization: `delete_work_organization`, method is `DELETE` with required parameter of `id`. It's same as any other deletion.

 Example:
 ```
 {
    "id": 1 //Required
 }
```

#### Employees endpoints:

 - Create employee: `create_employee`, method is `POST`. This is little bit different. It also got an avatar which is basically an image which is uploaded for particular employee. Apart from that it also have an, `lastName`, `firstName`, `work_org_id`, `sec_id` fields. Last mentioned is `id` of security official who entered his info. All of them are required, except avatar image. There is default one until user decides to updates it. It's `formData`.

 - List employees: `list_employees`, method is `GET` without parameters.

 - Show employee: `show_employee`, method is `GET` with single parameter of `id`. It lists single employee.

 Example:
 ```
    {
        "id": 1 //Required
    }
```

 - Update employee: `update_employee`, method is `PATCH` with same set of parameters like creating, but with added `id` for existing employee. Only `id` is required. It's also `formData`.

 - Delete employee: `delete_employee`, method is `DELETE` with single parameter of `id`. Same as previous.

  Example:
 ```
    {
        "id": 1 //Required
    }
```

#### Delivery endpoints:

 - Create delivery: `create_delivery`, method is `POST` with numerous parameters. 

 Example:
 ```
    {
        "load_place": "Smederevo1", //Required
        "unload_place": "Aranđelovac1", //Required
        "comment": "isporuka", //Required
        "time_in": "06:24", //Required
        "time_out": "07:22", //Required
        "vehicles": [1, 2], //Required
        "delivery_notes": [67854654, 24566784], //Required
        "operator_id": 1, //Required
        "sec_id": 1 //Required
    }
 ```
"time_out" and "time_in" parameters are when vehicle passed the gate, make their delivery and and came back.
"delivery_notes" are notes for specific delivery. Can be anything.

 - List deliveries: `list_deliveries`, method is `GET` without parameters. List all deliveries.

 - Show delivery: `show_delivery`, method is `GET` with single parameter of `id` for getting specific delivery.

 Example:
 ```
     {
        "id": 2 //Required
     }
 ```

 - Update delivery: `update_delivery`, method is `PATCH` with parameters exactly as creating, but also with addionional one, an `id` which serves to identify which delivery record needs to be updated.

 Example:
 ```
 {
    "id": 1, //Required
    "load_place": "Smederevo2", //Not required
    "unload_place": "Aranđelovac1", //Not required
    "comment": "isporuka", //Not required
    "time_in": "06:24", //Not required
    "time_out": "07:22", //Not required
    "vehicles": [1, 2], //Not required
    "delivery_notes": [67854654, 24566784], //Not required
    "operator_id": 1, //Not required
    "sec_id": 1 //Not required
 }
 ```

 - Delete delivery: `delete_delivery`, method is `DELETE` with `id` to identify which one to delete.

 Example:
 ```
    {
        "id": 1 //Required
    }
 ```

#### Special permissions endpoints:

 - Create special permission: `create_special_permissions`, method is `POST` with two fields, `permission_name` and `permission_description` which both serve as additional explanation to specific deliveries.

 Example:
 ```
    {
        "permission_name": "permission2", //Required
        "permission_description": "druga permisija" //Required
    }
 ```

 - List special permissions: `list_special_permissions`, method is `GET` without parameters.

 - Show special permissions: `show_special_permissions`, method is `GET` with `id` for identifying specific one.

 Example: 
 ```
    {
        "id": 1 //Required
    }
 ```

 - Update special permission: `update_special_permissions`, method is `PATCH` with two fields and `id` for identifying which one.

 Example:
 ```
    {
        "id": 1, //Required
        "permission_name": "permission1", //Not required
        "permission_description": "xxx", //Not required
        "sec_id": 1 //Required
    }
 ```

 - Delete special permission: `delete_special_permissions`, method is `DELETE` with an `id` of one.

 Example:
 ```
    {
        "id": 1 //Required
    }
 ```

#### Custom reports endpoints:

 - Get models: `getModels`, method is `GET` without parameters. Shows all available models. 

 - Get vehicles: `vehicles`, methos is `GET` with several parameters for query filtering. `start_date` from which date you should start your query( it checks updated_at), `end_date` which is another border date. `vehicle_id` which is optional, if ommited, it will lookup for all vehicles. `vehicle` is array type parameter. It can contain `user`, `type` and `workOrganization` which serves to add additional(optional) info on vehicle.

 Example:
 ```
    {
        "start_date": "17/07/2021", //Not required
        "end_date": "30/07/2021", //Not required
        "vehicle_id": 1, //Not required
        "vehicle": [
            "user",
            "type",
            "workOrganization"
        ] //Not required
    }
 ```

 - Get deliveries: `deliveries`, method is `GET` with several parameters, `start_date` from which date you should start your query( it checks updated_at), `end_date` which is another border date. `delivery` which is array type parameter. It can contain `operator` i.e. employee, `enteredBy` which is what security officer entered it in system and `complement` which is basically when truck + cistern go together.

 Example:
 ```
    {
        "start_date": "17/07/2021", //Not required
        "end_date": "30/01/2022", //Not required
        "delivery_id": 1, //Not required
        "delivery": [
            "operator",
            "enteredBy",
            "complement"
        ] //Not required
    }
 ```

- Get employees: `employees`, method is `GET` with several parameters. Almost as same as previous, but it's array parameter is `employee` with it's additional info, `work_organization`, `enteredBy` and `deliveries`.

 Example:
 ```
     {
         "start_date": "17/07/2021", //Not required
         "end_date": "30/01/2022", //Not required
         "employee_id": 1, //Not required
         "employee": [
             "work_organization",
             "enteredBy",
             "deliveries"
         ] //Not required
     }
 ```

 - Get users i.e. security officers: `users`, method is `GET`. It also have several parameters and it only differs in it's array one.
 `user` which can contain `role`, `vehicles`, `deliveries`, `complement`, `delivery_details`, `special_permissions` and `employees`.

 Example:
 ```
    {
    "start_date": "17/07/2021", //Not required
    "end_date": "30/01/2022", //Not required
    "user_id": 1, //Not required
    "user": [
        "role",
        "vehicles",
        "deliveries",
        "complement",
        "delivery_details",
        "special_permissions",
        "employees"
    ] //Not required
 }
```

#### Not mentioned tables

Tables such: `vehicle_pivot` are for entering types of vehicles and `delivery_details` which connects which security officer entered which delivery info.

 - Get all vehicle types: `list_vehicle_pivot`, method is `GET` without parameters.

 - Create vehicle type: `create_vehicle_pivot`, method is `POST` with single parameter, `name`.

 Example:
 ```
    {
        "name": test1 //Required
    }
 ```

 - Show vehicle type: `show_vehicle_pivot`, method is `GET` with single `id` parameter.

 Example:
 ```
    {
        "id": 3 //Required
    }
 ```

 - Update vehicle type: `update_vehicle_pivot`, method is `PATCH` with two parameters, `id` and `name`. First one is required.

 Example:
 ```
    {
        "id": 3, //Required
        "name": "test123" //Required
    }
 ```
 
 - Delete vehicle type: `delete_vehicle_pivot`, method is `DELETE` with `id` as parameter.

  Example:
 ```
    {
        "id": 3 //Required
    }
 ```
  All of endpoints have this header:

 ```
    'Content-Type': 'application/json',
    "Accept": 'application/json',
    "Authorization": "Bearer " + auth.access_token

```