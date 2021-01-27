# Toshokan Biblioteca

---
This library system for libraries
It is still in beginnings of development.

### Creating an account
**Note**: No one can create an account until the owner creates an owner account which can only be created by using `tinker`. After creating the owner account, log in to create a librarians. If a visitor wants to be a patron, a librarian will create the account for them.
1. Run `php artisan tinker` in command prompt
2. `$user = new App\User();` <kbd>Enter</kbd>
3. `$user->user_type = "owner";` <kbd>Enter</kbd>
4. `$user->username = "<your own username>";` <kbd>Enter</kbd>
5. `$user->password = Hash::make("<a secure password>");` <kbd>Enter</kbd>
6. `$user->first_name = "<first name>";` <kbd>Enter</kbd>
7. `$user->last_name = "<last name>";` <kbd>Enter</kbd>
8. `$user->save();` <kbd>Enter</kbd> *Should return true*
9. `exit` <kbd>Enter</kbd>

Below will be *some* of its functionalities
| Owner      | Librarians | Patrons | Visitors |
| :-----------: | :-----------: | :-----------: | :-----------: |
| Create librarians | Create patrons | Login | Search books |
| Disable librarians | Update patrons | Place hold for books |   |
| Edit librarians | Disable patrons | Pay late fees |    |
| View history log | Add books | Request replacement library card |   |
|   | Return books | Renew checkout books |   |
|   | Delete books |    |    |
|   | Lend books (need patron #) |    |    |

#### Made with
- Laravel 8
