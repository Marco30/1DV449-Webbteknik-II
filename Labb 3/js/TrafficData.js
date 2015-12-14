"use strict";

var TRMAP = TRMAP || {};



TRMAP.getTrafficsData = function()
{

	var trafficItemList = TRMAP.getTrafficsDataAjax();

}

/*fukntionen här nere kallar på ajax.php som sedan kallar på fukntionen i SradioModel.php som hämtar alla JSon data från Sveriges Radio
 fukntionen lägger  också in alla trafikinfo i vars sitt TrafficInfoItem objekt, som sädan läggs i en array som blir vår objekt lista.*/

TRMAP.getTrafficsDataAjax = function()
{

	var trafficItemList = [];

    $.ajax({
		type: "GET",
		url: "model/ajax.php",
		data: { "action": "getLatest"},
		dataType : "json"
		}).done(function(data) {
			
			console.log(data);

			var messages = data['retrievedData'];
			
			  function DateSort(a, b) 
			  {
                if (a.createddate < b.createddate)
                    return 1;
           
                return 0;
            }

            messages.sort(DateSort);

			for(var message in messages) {

				trafficItemList.push(new trafficInfoItem(	
											messages[message].category,
											messages[message].createddate,
											messages[message].description,
											messages[message].exactlocation,
											messages[message].id,
											messages[message].latitude,
											messages[message].longitude,
											messages[message].priority,
											messages[message].subcategory,
											messages[message].title
										));

			}

			TRMAP.trafficItems = trafficItemList;

			TRMAP.SetChosenCategoryToMap(TRMAP.constants.CATEGORY_ALL_CATEGORIES);// sätter ut alla händelser i kartan körs när start sida laddas

		}).fail(function (jqXHR, textStatus) {
			console.log("Faail: " + textStatus);
		});
}


function trafficInfoItem(category, createddate, description, exactlocation, id, latitude, longitude, priority, subcategory, title) // funktion som ska ta imot JSondata och bilda objekten som ska populera sidan
{

	// vi genom splits bearbetar unix datumen och gör dem till läsbar datum som ska precenteras
	var firstSplit = createddate.split('+')[0];
	var secondSplit = firstSplit.split('(')[1];
	var date = new Date();
	date.setTime(secondSplit);

	this.category = category;
	this.createddate = date;
	this.description = description;
	this.exactlocation = exactlocation;
	this.id = id;
	this.latitude = latitude;
	this.longitude = longitude;
	this.priority = priority;
	this.subcategory = subcategory;
	this.title = title;
	this.marker = null;
	this.infowindow = null;
}

