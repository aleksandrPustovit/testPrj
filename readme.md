API usage.
POST request 
    URL /documents
    parameters: 
        title  Str, min. lenfth 5 char;
        user_id Int, existing user id

PUT request 
    URL /documents/{id}?api_token=API_TOKEN
    parameters:
        id existing document id
        
DELETE request
    URL /documents/{id}?api_token=API_TOKEN
    parameters:
        id existing document id
        
