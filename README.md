# PcHatP

Hello fellow developer from bunq,

My name is Sadat. Nice to meet you.

## Get Started
You may run `compsoer dev` to get started.

  - Create a user and room 
  - Send a message in room
  - When creating multiple users, use POST /users/:id to select a user

## Endpoints

### Users
  - POST /users {username} create a new User
  - PUT /users/:id {username} edit user (username)
  - GET /users list all users
  - POST /users/:id select a user (mark as active user)
  - GET /users/active get active user

### Rooms
  - POST /rooms {name} create a new Room
  - PUT /rooms/:id edit room (name)
  - GET /rooms/:id/users list all users in room
  - GET /room/:id/messages list all messages in room

### Messages
  - POST /messages {message:string, room:integer} to send a message


