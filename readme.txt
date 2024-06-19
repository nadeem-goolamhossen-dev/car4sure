Car4Sure Insurance Policy Management
Developped using symfony 7

I preferred to use symfony instead of inventing the wheel for its folder structure, aspect of MVC and other features in
terms of security.

My way of implementing the system is to provide a login system to cater for authorized persons only to access the system
. The authorized user has access to a dashboard where he/she can use the links to add a person (policy holder, driver),
vehicles, and create a policy with all these entities.

For smooth running, I have added a command that initializes the app by :
1) Dropping the database
2) Creating the database and executes the migrations
3) Generate dummy data.