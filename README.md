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

  All of endpoints have this header:

 ```
    'Content-Type': 'application/json',
    "Accept": 'application/json',
    "Authorization": "Bearer " + auth.access_token

```