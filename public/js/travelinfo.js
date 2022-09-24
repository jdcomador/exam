function printWeatherInfo(weatherInfo) {
    var weatherDetails = weatherInfo.weather;
    var weatherName = ""; 
    var weatherDesc = "";
    var temperature = weatherInfo.main.temp+"°C";
    var temperatureFeelsLike = "feels like "+weatherInfo.main.feels_like+"°C";
    var visibility = (weatherInfo.visibility/1000)+"km";
    var humidity = weatherInfo.main.humidity+"%";
    var windSpeed = weatherInfo.wind.speed+"m/s";
    var windDegree = weatherInfo.wind.deg+" degrees";
    var cloudiness = weatherInfo.clouds.all+"%";
    //converts to local time in japan
    var sunrise = new Date(weatherInfo.sys.sunrise*1000).toLocaleString("ja-JP");
    var sunset = new Date(weatherInfo.sys.sunset*1000).toLocaleString("ja-JP");
    for(var i = 0; i < weatherDetails.length; i++) {
        if(i != 0) {
            weatherName += "/";
            weather_desc += "/";
        }
        weatherName += weatherDetails[i].main;
        weatherDesc += weatherDetails[i].description;
    }
    $("#weather_name").text(weatherName);
    $("#weather_desc").text(weatherDesc);
    $("#temperature").text(temperature);
    $("#temperature_feels_like").text(temperatureFeelsLike);
    $("#wind_speed").text(windSpeed);
    $("#wind_degree").text(windDegree);
    $("#cloudiness").text(cloudiness);
    $("#humidity").text(humidity);
    $("#visibility").text(visibility);
    $("#sunrise").text(sunrise);
    $("#sunset").text(sunset);

}

function printPlaceInfo(placeInfo) {
    var placeDetails = placeInfo.results;
    var placeHtml = "";
    // $("#place_name_1").text(placeDetails[0].name);
    // $("#place_address_1").text(placeDetails[0].location.formatted_address);

    for(var i = 0; i < placeDetails.length; i++) {
        var place = "";
        place += '<div class="row mb-3 text-start">';
        place += '<div class="col-6">';
        place += '<label class="col-form-label col-form-label-sm">Name:</label>';
        place += '<p class="fs-5">'+placeDetails[i].name+'</p>';
        place += '</div>';
        place += '<div class="col-6">';
        place += '<label class="col-form-label col-form-label-sm">Address:</label>';
        place += '<p class="fs-5">'+placeDetails[i].location.formatted_address+'</p>';
        place += '</div>';
        place += '</div>';

        placeHtml += place;
    }

    $("#place_details").html(placeHtml);
}