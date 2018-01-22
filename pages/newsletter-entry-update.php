<?php
/* TODO
	- update spreadsheet
	- bust cache
	- fetch data all over again
	- return the one bit of data
*/

//$logger = new Logger();
//$logger->dumpText();
sleep(2);
$json = <<<JSON
	{
		"row":
        {
            "metadata": {
                "id": 4,
                "category": "Video"
            },
            "actions": {
                "markAsUsed": false,
                "discarded": true
            },
            "preview": {
                "timestamp": "1\/20\/2018 10:57:38",
                "email": "mgramont@gmail.com",
                "url": "https:\/\/www.youtube.com\/watch?v=yDg-_64uYVg",
                "title": "MBS International team rider - Yuya Nakayama - YouTube",
                "image": "https:\/\/i.ytimg.com\/vi\/yDg-_64uYVg\/hqdefault.jpg",
                "description": "Yuya Nakayama promo video",
                "IMAComment": ""
            }
        }
    }
JSON;

echo $json;