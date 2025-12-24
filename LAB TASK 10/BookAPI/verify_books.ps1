$baseUrl = "http://127.0.0.1:8000/api/books"

Write-Host "---------------------------------------------------"
Write-Host "1. Testing POST (Store)..."
$body = @{
    title = "The Great Gatsby"
    author = "F. Scott Fitzgerald"
    published_year = 1925
    genre = "Classic"
    isbn = "9780743273565"
} | ConvertTo-Json
Try {
    $response = Invoke-RestMethod -Uri $baseUrl -Method Post -Body $body -ContentType "application/json"
    Write-Host "SUCCESS: Created Book"
    Write-Host ($response | ConvertTo-Json -Depth 2)
    $id = $response.id
} Catch {
    Write-Error "FAILED: $_"
    exit
}

Write-Host "`n---------------------------------------------------"
Write-Host "2. Testing GET (Index)..."
Try {
    $books = Invoke-RestMethod -Uri $baseUrl -Method Get
    Write-Host "SUCCESS: Retrieved Books List"
    Write-Host ($books | ConvertTo-Json -Depth 2)
} Catch {
    Write-Error "FAILED: $_"
}

if ($id) {
    Write-Host "`n---------------------------------------------------"
    Write-Host "3. Testing GET (Show ID: $id)..."
    Try {
        $book = Invoke-RestMethod -Uri "$baseUrl/$id" -Method Get
        Write-Host "SUCCESS: Retrieved Single Book"
        Write-Host ($book | ConvertTo-Json -Depth 2)
    } Catch {
        Write-Error "FAILED: $_"
    }

    Write-Host "`n---------------------------------------------------"
    Write-Host "4. Testing PUT (Update ID: $id)..."
    $updateBody = @{
        title = "The Great Gatsby (Updated)"
    } | ConvertTo-Json
    Try {
        $updatedBook = Invoke-RestMethod -Uri "$baseUrl/$id" -Method Put -Body $updateBody -ContentType "application/json"
        Write-Host "SUCCESS: Updated Book"
        Write-Host ($updatedBook | ConvertTo-Json -Depth 2)
    } Catch {
        Write-Error "FAILED: $_"
    }

    Write-Host "`n---------------------------------------------------"
    Write-Host "5. Testing DELETE (Destroy ID: $id)..."
    Try {
        $deleteResponse = Invoke-RestMethod -Uri "$baseUrl/$id" -Method Delete
        Write-Host "SUCCESS: Deleted Book"
        Write-Host ($deleteResponse | ConvertTo-Json -Depth 2)
    } Catch {
        Write-Error "FAILED: $_"
    }
}

Write-Host "`n---------------------------------------------------"
Write-Host "Final Check (Index)..."
$booksFinal = Invoke-RestMethod -Uri $baseUrl -Method Get
Write-Host ($booksFinal | ConvertTo-Json -Depth 2)
