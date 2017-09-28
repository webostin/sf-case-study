# Short App description

We have Movie Entity. We have complex caching system for cache movies pagination and movies itself. We have frontend panel and backend panel.
We have User Entity attached to Movie. We have also Admin Entity.

# Problem

We need to soft delete Movie and at the same time reset cache and send email. We have to make it in two (or in future more) contexts:

1. Frontend User deletes Movie attached to him. Action: soft remove, reset cache, send email to admin;
2. Admin deletes Movie. Action: soft remove, cache restart, send email to User.
3. Cron while checking Movie data disables the movie. Action: soft remove, reset cache, send emails to Admin and User

# 3 study cases

## controller-like: 2 controllers, everything happens in method of controller and 1 console command each mathod is repeating all proccess

Disadventages:
* reset cache and remove movie repeats in 2 controllers
* difficult to add new features to remove Movie
* high risk of errors when new dev is changing something in one controller but does not change in the second one
* more?

Advantages:
* fast and easy to differentiate the context of remove

## listener-like: 2 controllers with two different methods and console command - firing up MovieDisableEvent

Disadvantages:
* need to provide context to the event
* need to write listener (separate class)
* difficult to differ between context (at begging it is only User or Admin but it may become more complex)
* needs more time to understand the code

Advantages:
* everything at one place
* easy to overwrite (not change but overwrite by extending or replacing EventListener class)

## service-like: the same as listener but creates more readable method name and parameters as context

Disadvantages:
* need to provide parameters to call function
* need to write service (separate class, config, di)
* difficult to extend context (at begging it is only User or Admin but it may become more complex) - by adding parameters?

Advantages:
* everything at one place
* easy to overwrite (not change but overwrite by extending or replacing Service class)
* readable method name


# Comments are welcome

Write a comment or your opinion to this case. Or write another study-case or correct my. Every action is welcome!