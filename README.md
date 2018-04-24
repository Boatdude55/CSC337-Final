# MineSweeper Game

    For our project we built a Minesweeper game.
    
## Specs

The client will initiate the Minesweeper service. 
### index.php
The home portal gives the client the option to Play Now, Register, Login, or view leaderboard. 

#### Modes

##### On Play Now
The client will play  the Minesweeper game. The difficulty is chosen automatically for the client and so is the style.
When the client has won or lost the game they will be able to play again, or save score (This requires being a registered user).

##### On Register
The client is prompted to enter credentials for their account, on credential error the client is re-prompted and on credential success the user is routed to login service.

##### On Login
The client is served the elevated hub they will be able to Play Now, Logout, or use additional user features like editing game aesthetics, difficulty, and save score.

##### On view leaderboard
The client is served the leaderboard of registered users.

##### On logout
The user is routed to default hub.