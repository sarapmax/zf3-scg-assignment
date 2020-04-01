## SCG Assignment - API (Backend) 


### Installation

1. Clone the project
```
$ git clone https://github.com/sarapmax/zf3-scg-assignment.git
```

2. Install composer dependencies
```
$ composer install
```

3. Run the web <br/>
There are several ways to run the web like XAMPP, PHP Built-in, etc. In my case, I use a really cool package called Laravel Valet. I can just simply browse:
```
http://zf3-scg-assignment.test
```

### API Endpoints

According to the assignment instruction, there are 3 API endpoints you can visit to see the result.

(1) X, Y, 5, 9, 15, 23, Z - Please create a new function for finding X, Y, Z value
```
http://zf3-scg-assignment.test/api/doscg/sequence
```

(2) If A = 21, A + B = 23, A + C = -21 - Please create a new function for finding B and C value
```
http://zf3-scg-assignment.test/api/doscg/equation
```
(3) Please use “Google API” for finding the best way to go to Central World from SCG
    Bangsue
```
This has been done in the client side.
```
(4) Please create a small project using Line messaging API for getting a notification when
    your Line Bot can not answer a question to the customer more than 10 second
```
http://zf3-scg-assignment.test/api/doscg/linebot
```
This URL (when deployed) is used as a webhook in Line Bot Messaging API.
