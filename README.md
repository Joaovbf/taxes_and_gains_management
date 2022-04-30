## API Documentation

### GET | /user/{id}/investments

Get paginated investments of an user

**Query String:**

 - page(int): select the page
 - perPage(int): limit the quantity of data per page

### GET | /investment/{id}

Get an investment

### POST | /withdraw

Create a withdraw

**JSON params:**

- investment_id(int): id of an existing investment
- created_at(datetime): optional date of withdraw creation
