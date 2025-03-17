# PcHatP

Hello fellow developer from bunq,

My name is Sadat. Nice to meet you.

## Get Started
You may run `composer dev` to serve locally. (http://localhost:8080)

  - Create a user and room 
  - Join room or send a message in one to get started
  - When creating multiple users, use POST /users/:id to select a user

DDD-based application. Find controller classes in src\Application\Actions and models in src\Domain

## Endpoints

### Users
  - POST /users {username} - create a new User
  - PUT /users/:id {username} -  edit user (username)
  - GET /users - list all users
  - POST /users/:id - select a user (mark as active user)
  - GET /users/active - get active user

### Rooms
  - POST /rooms {name} - create a new Room
  - PUT /rooms/:id {name} - edit room (name)
  - POST /rooms/:id/join - join the room
  - GET /rooms/:id/users - list all users in room
  - GET /room/:id/messages - list all messages in room

### Messages
  - POST /messages {message:string, room:integer (ID} - send a message (sent by active-user in the session)


