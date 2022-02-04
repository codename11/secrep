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



  All of endpoints have this header:

 ```
    'Content-Type': 'application/json',
    "Accept": 'application/json',
    "Authorization": "Bearer " + auth.access_token

```