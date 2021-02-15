# Toshokan-Biblioteca
A library book system for libraries

### Owner Account Creation
Run in the command line `php artisan owner:create` and answer the questions to create the owner account

### Account Types
- Owner
    - View library statistics
    - Librarians
        - View list
        - Invite (Create)
            - new librarian will have to create own password
        - Delete
        - Disable
    - Patrons
        - View list
        - Create
            - All fields required except, username, email, password (4 digit pin # randomly generated)
            - Link visitor account into patron
        - Edit
    - Books
        - Create
        - Edit
        - Delete
        - Lend
        - Return
    - Settings
- Librarians
    - Patrons (same as owner),
    - Books (same as owner)
- Patrons
    - View checkouted out books
    - Place book on hold
    - View/Pay late fees
    - Add to read list
- Visitors
    - Add to read list
