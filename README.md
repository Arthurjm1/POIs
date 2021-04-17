# Pontos de interesse - GPS

A service that can be used to locate points of interest in a certain range.

## Usage

First, set up your database parameters in the "app/settings.php" file.

Then, just be sure you're the "public" directory an run in your terminal:
```
php -S localhost:8080
```
Now you should be ready to make your requests

## Requests

### Set points of interest

```
Post
localhost:8080/poi/add
data: { "description" : "POI's description",
        "x" : "X coordinate", 
        "y" : "Y coordinate" }
```

### List all points of interest

```
Get
localhost:8080/poi/list
```

### Find points of interest in a certain range

```
Post
localhost:8080/poi/find
data: { "x" : "X coordinate of your current place",
        "y" : "Y coordinate of your current place", 
        "dmax" : "Range of search" 
```