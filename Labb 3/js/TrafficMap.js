"use strict";

var TRMAP = TRMAP || {};


TRMAP.onlineMode = true;

TRMAP.currentInfoWindow = null;
TRMAP.activeMarkers = [];

TRMAP.constants =
{
	CATEGORY_ALL_CATEGORIES: "Alla",
	CATEGORY_ROAD_TRAFFIC: "Vegtrafik",
	CATEGORY_PUBLIC_TRANSPORT: "Kollektivtrafik",
	CATEGORY_PLANNED_INTERUPTION: "Planerad",
	CATEGORY_OTHERS_CATEGORY: "ovrigt"
}


TRMAP.initialize = function()
{

	TRMAP.createMap();

	TRMAP.getTrafficsData();

	TRMAP.MenuUsedToSortTraffic();

}

TRMAP.MenuUsedToSortTraffic = function()
{

	var AllCategoriesButton = document.getElementById(TRMAP.constants.CATEGORY_ALL_CATEGORIES);

	AllCategoriesButton.onclick = function ()// känner av när du klickat på länken Alla kategorier i menyn
	{
		// kallar på funktion som soretar och precenterar trfaiki info och sätter ut markerare på kartan
		TRMAP.SetChosenCategoryToMap(TRMAP.constants.CATEGORY_ALL_CATEGORIES);
	};

	var RoadTrafficButton = document.getElementById(TRMAP.constants.CATEGORY_ROAD_TRAFFIC);

	RoadTrafficButton.onclick = function ()// känner av när du klickat på länken Vägtrafik i menyn
	{
		// kallar på funktion som soretar och precenterar trfaiki info och sätter ut markerare på kartan
		TRMAP.SetChosenCategoryToMap(TRMAP.constants.CATEGORY_ROAD_TRAFFIC);
	};

	var PublicTransportButton = document.getElementById(TRMAP.constants.CATEGORY_PUBLIC_TRANSPORT);

	PublicTransportButton.onclick = function ()
	{
		TRMAP.SetChosenCategoryToMap(TRMAP.constants.CATEGORY_PUBLIC_TRANSPORT);
	};

	var PlannedInteruptionButton = document.getElementById(TRMAP.constants.CATEGORY_PLANNED_INTERUPTION);

	PlannedInteruptionButton.onclick = function ()
	{
		TRMAP.SetChosenCategoryToMap(TRMAP.constants.CATEGORY_PLANNED_INTERUPTION);
	};

	var OthersButton = document.getElementById(TRMAP.constants.CATEGORY_OTHERS_CATEGORY);

	OthersButton.onclick = function ()
	{
		TRMAP.SetChosenCategoryToMap(TRMAP.constants.CATEGORY_OTHERS_CATEGORY);
	};
}



TRMAP.SetChosenCategoryToMap = function(category)
{

	var itemsInCategory = TRMAP.getItemsInCategory(category);// Fuktion som solar och ger till bak en solad lista på alla objket som passar den valda kategorin

	TRMAP.addMarkers(itemsInCategory);// löpper igenom listan och lägger ut all objekten

	TRMAP.addDataToList(itemsInCategory);//läger till så att det precenteras som en lista i menyn

}

TRMAP.getItemsInCategory = function(category)//sorterar listan och ger oss en lista med den valda kategorin
{

	var itemsInCategory = [];

	var categoryInNumber;

	switch(category)
	{
		case TRMAP.constants.CATEGORY_ALL_CATEGORIES:
			categoryInNumber = 4;
			break;

		case TRMAP.constants.CATEGORY_ROAD_TRAFFIC:
			categoryInNumber = 0;
			break;

		case TRMAP.constants.CATEGORY_PUBLIC_TRANSPORT:
			categoryInNumber = 1;
			break;

		case TRMAP.constants.CATEGORY_PLANNED_INTERUPTION:
			categoryInNumber = 2;
			break;

		case TRMAP.constants.CATEGORY_OTHERS_CATEGORY:
			categoryInNumber = 3;
			break;

	}

	if(category == TRMAP.constants.CATEGORY_ALL_CATEGORIES)
	{
		itemsInCategory = TRMAP.trafficItems;
	}
	else
	{

		for(var itemNumber in TRMAP.trafficItems)
		{
			var currentItem = TRMAP.trafficItems[itemNumber];

			if(categoryInNumber == currentItem.category)
			{
				itemsInCategory.push(currentItem);
			}
		}
	}

	return itemsInCategory;
}

TRMAP.deleteMarkersFromMap = function () // tar bort marker från googel map
{

	for(var marker in TRMAP.activeMarkers)
	{
		TRMAP.activeMarkers[marker].setMap(null);
	}
}


TRMAP.createMap = function() //skpar googel map med kordinaterna där jag är just nu
{

	var myLatlng = new google.maps.LatLng(62.88722932,17.91876062);

    var mapOptions = {
      center: myLatlng,
      zoom: 5
    };

	TRMAP.map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
}


TRMAP.addMarkers = function(itemsInCategory)// läger till makrerks i googel maps
{

	if(TRMAP.activeMarkers.length > 0)// tar bort markers som fins i kartan
	{
		TRMAP.deleteMarkersFromMap();
	}

	for(var itemNumber in itemsInCategory)// lopar igenom listan och läger utt infom på googel maps och skapar html tagar som ska visas när man klikar på markern
	{

		var currentItem = itemsInCategory[itemNumber];

		var myLatlng = new google.maps.LatLng(currentItem.latitude,currentItem.longitude);

		
		var marker = new google.maps.Marker({position: myLatlng, map: TRMAP.map, title:'Marco är Kung', draggable:false,});
		
		// skpar info rutan som visas när man klickar på en marker
		var contentString = '<div id="content">'+
							      '<div id="siteNotice">'+
							      '</div>'+
							      '<p>' + currentItem.createddate + " |  Katergori: " + currentItem.subcategory + '</p>' +
							      '<h1 id="firstHeading" class="firstHeading">' + currentItem.title + '</h1>'+
							      '<div id="bodyContent">'+
							      '<p>' + currentItem.description + '</p>'+
							      '</div>'+
						      '</div>';

		var infowindow = TRMAP.attachInfoWindow(marker, contentString);// koplar makrer och info rutan som ska visas till den
		
		currentItem.marker = marker;
		currentItem.infowindow = infowindow;

		TRMAP.activeMarkers.push(marker);
	}

}

TRMAP.attachInfoWindow = function (marker, contentString)// här koplas marker och info rutan som ska visas till den
{
  
	var infowindow = new google.maps.InfoWindow({content: contentString});

	google.maps.event.addListener(marker, 'click', function()
	{
		if(TRMAP.currentInfoWindow != null)
		{
			TRMAP.currentInfoWindow.close();
		}
		
		infowindow.open(marker.get('map'), marker);
		TRMAP.currentInfoWindow = infowindow;
	});

	return infowindow;
}

TRMAP.addDataToList = function(itemsInCategory)// läger till data till listan som visas under meny
{

	 var eventsList = document.getElementById("eventsList");

	 eventsList.innerHTML = '';	 


	 for(var itemNumber in itemsInCategory)
	 {

	 	var item = itemsInCategory[itemNumber];

	 	var newEventListElement = document.createElement("li");

	 	var listLink = document.createElement("a");

	 	listLink.setAttribute("href", "#");

		var eventDescription = document.createTextNode(item.title);

		listLink.appendChild(eventDescription);

		newEventListElement.appendChild(listLink);

		TRMAP.setOpenInfowindowEvent(newEventListElement, item);

		eventsList.appendChild(newEventListElement);

	 }
}


TRMAP.setOpenInfowindowEvent = function (element, item)// Funktion som kontrollerar att ett fönster i taget är öppet
{

	element.onclick = function(e)
	{

		if(TRMAP.currentInfoWindow != null)
		{
			TRMAP.currentInfoWindow.close();
		}

		item.infowindow.open(item.marker.get('map'), item.marker);
		TRMAP.currentInfoWindow = item.infowindow;
	}
}





window.onload = TRMAP.initialize;