# Weather API - Laravel Developer Task

We will use [**OpenWeatherMap API**](https://openweathermap.org/current) to get current weather data based on latitude/longitude.

- **API Link**: [https://openweathermap.org/current](https://openweathermap.org/current)
- **API Key**: `Get it from OpenWeatherMap website`
- **Technology: Laravel, MySQL, Redis**

---

# Task

- Pull the weather information of the cities of Uzbekistan and store it in the database every hour.
- Create APIs to retrieve weather data with API Documentation.
- Cover your APIs, functions and services with PHPUnit/Pest test-cases

# Rest API Endpoints

- `GET /api/cities`: Get the list of the stored cities
- `GET /api/weather/{city}`: Get the historical weather information for city
- `GET /api/weather/{city}/latest`: Get the latest weather information for city
- `GET /api/weather`: Get the list of the stored all weather data

# Data Models

### City Model

- City name
- Latitude
- Longitude

### Weather Model:

- City
- Time
- Weather name
- Latitude
- Longitude
- Temperature (in Celsius)
- MIN Temperature (in Celsius)
- MAX Temperature (in Celsius)
- Pressure
- Humidity

# Example Cities

| Name    | Latitude | Longitude |
|---------|----------|-----------|
| Tashkent | 41.2995 | 69.2401 |
| Samarkand | 39.6542 | 66.9597 |
| Bukhara | 39.7745 | 64.4286 |
| Khiva | 41.3786 | 60.3560 |
| Nukus | 42.4611 | 59.6164 |
| Andijan | 40.7821 | 72.3442 |
| Namangan | 40.9983 | 71.6726 |
| Fergana | 40.3864 | 71.7864 |
| Termiz | 37.2241 | 67.2783 |
| Kokand | 40.5306 | 70.9428 |

# Submission:

Fork this repository and make your changes in that forked repo. Once you finish the task, create Pull Request from the forked repo to the main repo. Tag following people as reviewer in your PR and notify the recruiter:
- @Sherlockboy

Also, update the readme with the instructions of how to run the project and get the data locally.
