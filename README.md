[![](https://scdn.rapidapi.com/RapidAPI_banner.png)](https://rapidapi.com/package/Cronofy/functions?utm_source=RapidAPIGitHub_CronofyFunctions&utm_medium=button&utm_content=RapidAPI_GitHub)

# Cronofy Package
One Calendar API for all the calendar services. We've handled all the complexity of integrating, maintaining, and monitoring activity across the major calendar service providers. Because we've done this, you're finally free to use your customers' calendars as an extension of your service.You can put the information your customer needs, at the time they need it, in the place they need it and build better experiences.
* Domain: [www.cronofy.com](https:\/\/www.cronofy.com\/)
* Credentials: clientId, clientSecret

## How to get credentials: 
0. Register on the [www.cronofy.com](https:\/\/www.cronofy.com\/)
1. [Create](https:\/\/app.cronofy.com\/oauth\/applications\/new) an application for a new API credentials
2. After creation app you will see API credentials in app settings

## Custom datatypes: 
 |Datatype|Description|Example
 |--------|-----------|----------
 |Datepicker|String which includes date and time|```2016-05-28 00:00:00```
 |Map|String which includes latitude and longitude coma separated|```50.37, 26.56```
 |List|Simple array|```["123", "sample"]``` 
 |Select|String with predefined values|```sample```
 |Array|Array of objects|```[{"Second name":"123","Age":"12","Photo":"sdf","Draft":"sdfsdf"},{"name":"adi","Second name":"bla","Age":"4","Photo":"asfserwe","Draft":"sdfsdf"}] ```  
 
 ## Cronofy.getAccessToken
Access Tokens are issued as specified in section 4.1.3 of RFC 6749, authentication is performed by including your client_id and client_secret, as issued by Cronofy, within the body of the request.

| Field       | Type       | Description
|-------------|------------|----------
| clientId    | credentials| Your Client Id.
| clientSecret| credentials| Your Client Secret.
| code        | String     | The short-lived, single-use code issued to you when the user authorized your access to their account as part of an Authorization Request.
| redirectUri | String     | The same HTTP or HTTPS URI you passed when requesting the user's authorization.

## Cronofy.refreshAccessToken
Access Tokens are refreshed as specified in section 6 of RFC 6749, authentication is performed by including your client_id and client_secret, as issued by Cronofy, within the body of the request.

| Field       | Type       | Description
|-------------|------------|----------
| clientId    | credentials| The client_id issued to you by Cronofy to authenticate your OAuth Client. Authenticates you as a trusted client along with your client_secret.
| clientSecret| credentials| The client_secret issued to you by Cronofy to authenticate your OAuth Client. Authenticates you as a trusted client along with your client_id.
| refreshToken| String     | The refresh_token issued to you when the user authorized your access to their account.

## Cronofy.revokeAccessToken
You may wish to revoke your access on behalf of your users rather than directing them to our site, for example when they unsubscribe from your service or no longer want to use your calendar integration features.

| Field       | Type       | Description
|-------------|------------|----------
| clientId    | credentials| The client_id issued to you by Cronofy to authenticate your OAuth Client. Authenticates you as a trusted client along with your client_secret.
| clientSecret| credentials| The client_secret issued to you by Cronofy to authenticate your OAuth Client. Authenticates you as a trusted client along with your client_id.
| token       | String     | Either the refresh_token or access_token for the authorization you wish to revoke.It is recommended that you use the refresh_token as that cannot have expired and therefore be impossible to revoke. RFC 7009 does not provide any provision for a different response when the provided token has already been revoked, has already expired, or does not exist.

## Cronofy.extendedPermissions
As an extension of the OAuth flow users can be asked to grant unrestricted access to their calendars. This is implemented through a redirect to an additional access page.

| Field      | Type  | Description
|------------|-------|----------
| accessToken| String| The new Access Token to use to authenticate when using the API on behalf of the user.Will always be a 32 character String of ASCII characters.
| permissions| Array | Multiple calendar_id's can be provided in the permissions array, the only acceptable value for permission_level is unrestricted, further options may be added in future.
| redirectUri| String| The redirect_uri is the page which the user will be directed to after they have granted or rejected permission.

## Cronofy.getCalendarsPeriods
Inspects calendars to determine the common availablity for people within the specified periods of time.

| Field                    | Type  | Description
|--------------------------|-------|----------
| accessToken              | String| The new Access Token to use to authenticate when using the API on behalf of the user.Will always be a 32 character String of ASCII characters.
| participants             | List  | An list of the groups of participants whose availability should be taken into account.At least one group must be specified, a maximum of 10 accounts may be specified over a combination of groups.
| requiredDurationInMinutes| String| An object describing the minimum period that the participant groups must be satisfied for a period to be deemed as available.An Integer specifying the number of minutes that an available period must last to be considered viable.Must be a value of at least 1.
| availablePeriods         | Array | An array of 1 to 10 available periods, across up to 35 days, within which suitable matches may be found.

##### participants

Example request - 
```
{
      "members": [
        {
          "sub": "acc_59e751cac6318303c60001a8",
          "available_periods": [{
            "start": "2017-10-30T09:00:00Z",
            "end": "2017-10-30T12:00:00Z"
          },
            {
              "start": "2017-10-31T10:00:00Z",
              "end": "2017-10-31T20:00:00Z"
            }
          ]
        }
      ],
      "required": "all"
    }
    
```

## Cronofy.getRealTimeSchedulingUrl
Returns an URL to a form where a user can select their preferred date and time for an event based upon live availability information.

| Field                | Type       | Description
|----------------------|------------|----------
| clientId             | credentials| The client_id issued to you by Cronofy to authenticate your OAuth Client. Authenticates you as a trusted client along with your client_secret.
| clientSecret         | credentials| The client_secret issued to you by Cronofy to authenticate your OAuth Client. Authenticates you as a trusted client along with your client_id.
| redirectUri          | String     | The same HTTP or HTTPS URI you passed when requesting the user's authorization.
| state                | String     | A value that will be returned to you unaltered along with the user's Real-Time Scheduling journey decision.
| eventId              | String     | Id of the event you wish to push into the user's selected calendar.
| summary              | String     | Summary of the event you wish to push into the user's selected calendar.
| transparency         | Select     | A String value representing the transparency of the event.`opaque` - the account should appear as busy for the duration of the event.`transparent` - the account should not appear as busy for the duration of the event.If not provided, transparent is used for all-day events, and opaque for Time-based events.
| description          | String     | The String to use as the description, sometimes referred to as the notes, of the event.
| eventStart           | JSON       | The start time can be provided as a simple Time or Date string or an object with two attributes, time and tzid.
| eventEnd             | JSON       | The end time can be provided as a simple Time or Date string or an object with two attributes, time and tzid.
| tzid                 | String     | The timezone to render the event with.The start and end parameters should be omited.Example - Europe/Paris.
| reminders            | String     | You can provide an array of up to 5 reminders for an event. They should be provided in order of priority for your application, not time order. This is because the providers support a varying number of reminders and we will set as many as they allow, in the order you provide them.
| url                  | String     | A String value which must be parseable as a URI as defined as defined in RFC 1738 and RFC 2111.Omitting the value will leave the URL unchanged. Setting the value to null will remove the URL if supported by the provider.Support for event URLs is currently limited to Apple and Google. Please note there is an issue with Google whereby URLs are not removable once they are provided.
| availability         | JSON       | An object with the details of the availability query used to determine the available time periods for the user to choose for the event's date and time. Details of what parameters this object can hold can be found in the Availability documentation.
| targetCalendars      | Array      | An array of Cronofy IDs and calendar ids into which the final event will be inserted.
| callbackUrl          | String     | A URL to call when the full event details are known.
| formattingHourFormat | Select     | An String of either h (12-hour format) or H (24-hour format). If omitted then the hour format to use will be determined by Cronofy.
| suppressAddToCalendar| Select     | A boolean flag to indicate whether to suppress the display of the `Add To Calendar` option once the recipient has selected a time.

##### reminders

You can provide an array of up to 5 reminders for an event. They should be provided in order of priority for your application, not time order. This is because the providers support a varying number of reminders and we will set as many as they allow, in the order you provide them.
Number of reminders supported per provider:

- Apple 5 reminders, note that icloud.com will only display two
- Exchange 1 reminder
- Google 5 reminders
- Office 365 1 reminder
- Outlook.com 1 reminder

For example, if you provide 3 reminders and the provider only supports one, we will use the first one you specify, not the earliest or the latest one.
As a concrete example, whilst we advise erring on the side of setting less reminders rather than more, it is easy to imagine that 3 reminders may be useful for an appointment:
30 minutes before event start - get to the appointment;
24 hours before event start - remember about the appointment;
At event start - the appointment should have started;



##### eventStart/EventEnd
When localized_times is not specified or is false, the Time or Date representing when the free-busy period starts.
When localized_times is true, an object with two attributes, time and tzid : 
```
{
     "time": "2014-09-13T23:00:00+02:00",
     "tzid": "Europe/Paris"
}
   ```
The time attribute is the Time or Date representing when the free-busy period starts. This will be provided with an offset matching that of the corresponding tzid.
The tzid attribute specifies a String representing a known time zone identifier from the [IANA Time Zone Database](http://www.iana.org/time-zones).

Common examples are - 
- Etc/UTC
- Europe/Paris
- America/


##### availability

Request example - 

```
{
	"participants": [{
		"members": [{
			"sub": "acc_59e751cac6318303c60001a8",
			"calendar_ids": ["cal_We8l881iVl0TABL3_LB50xJaq0Shmz54Do4c1Mw"]
		}],
		"required": "all"
	}],
	"required_duration": {
		"minutes": 60
	},
	"available_periods": [{
		"start": "2017-10-30T09:00:00Z",
		"end": "2017-10-30T18:00:00Z"
	}]
}
```

## Cronofy.createCalendarAccessUrl
Returns an URL to a form where the user can select the calendar they wish to have it added to as part of authorizing calendar access for your application.

| Field               | Type       | Description
|---------------------|------------|----------
| clientId            | credentials| The client_id issued to you by Cronofy to authenticate your OAuth Client. Authenticates you as a trusted client along with your client_secret.
| clientSecret        | credentials| The client_secret issued to you by Cronofy to authenticate your OAuth Client. Authenticates you as a trusted client along with your client_id.
| redirectUri         | String     | The same HTTP or HTTPS URI you passed when requesting the user's authorization.
| state               | String     | A value that will be returned to you unaltered along with the user's Real-Time Scheduling journey decision.
| eventId             | String     | Id of the event you wish to push into the user's selected calendar.
| summary             | String     | Summary of the event you wish to push into the user's selected calendar.
| transparency        | Select     | A String value representing the transparency of the event.`opaque` - the account should appear as busy for the duration of the event.`transparent` - the account should not appear as busy for the duration of the event.If not provided, transparent is used for all-day events, and opaque for Time-based events.
| description         | String     | The String to use as the description, sometimes referred to as the notes, of the event.
| eventStart          | JSON       | The start time can be provided as a simple Time or Date string or an object with two attributes, time and tzid.
| eventEnd            | JSON       | The end time can be provided as a simple Time or Date string or an object with two attributes, time and tzid.
| tzid                | String     | The timezone to render the event with.The start and end parameters should be omited.Example - Europe/Paris.
| reminders           | String     | You can provide an array of up to 5 reminders for an event. They should be provided in order of priority for your application, not time order. This is because the providers support a varying number of reminders and we will set as many as they allow, in the order you provide them.
| url                 | String     | A String value which must be parseable as a URI as defined as defined in RFC 1738 and RFC 2111.Omitting the value will leave the URL unchanged. Setting the value to null will remove the URL if supported by the provider.Support for event URLs is currently limited to Apple and Google. Please note there is an issue with Google whereby URLs are not removable once they are provided.
| formattingHourFormat| Select     | An String of either h (12-hour format) or H (24-hour format). If omitted then the hour format to use will be determined by Cronofy.

##### eventStart/EventEnd
When localized_times is not specified or is false, the Time or Date representing when the free-busy period starts.
When localized_times is true, an object with two attributes, time and tzid : 
```
{
     "time": "2014-09-13T23:00:00+02:00",
     "tzid": "Europe/Paris"
}
   ```
The time attribute is the Time or Date representing when the free-busy period starts. This will be provided with an offset matching that of the corresponding tzid.
The tzid attribute specifies a String representing a known time zone identifier from the [IANA Time Zone Database](http://www.iana.org/time-zones).

Common examples are - 
- Etc/UTC
- Europe/Paris
- America/

##### reminders

You can provide an array of up to 5 reminders for an event. They should be provided in order of priority for your application, not time order. This is because the providers support a varying number of reminders and we will set as many as they allow, in the order you provide them.
Number of reminders supported per provider:

- Apple 5 reminders, note that icloud.com will only display two
- Exchange 1 reminder
- Google 5 reminders
- Office 365 1 reminder
- Outlook.com 1 reminder

For example, if you provide 3 reminders and the provider only supports one, we will use the first one you specify, not the earliest or the latest one.
As a concrete example, whilst we advise erring on the side of setting less reminders rather than more, it is easy to imagine that 3 reminders may be useful for an appointment:
30 minutes before event start - get to the appointment;
24 hours before event start - remember about the appointment;
At event start - the appointment should have started;

## Cronofy.getListCalendars
Returns a list of all the authenticated user's calendars.

| Field      | Type  | Description
|------------|-------|----------
| accessToken| String| The new Access Token to use to authenticate when using the API on behalf of the user.Will always be a 32 character String of ASCII characters.

## Cronofy.createCalendar
Creates a calendar within a user's profile.In order for this to be possible, you must request the create_calendar scope when requesting authorization to access the user's calendars.

| Field      | Type  | Description
|------------|-------|----------
| accessToken| String| The new Access Token to use to authenticate when using the API on behalf of the user.Will always be a 32 character String of ASCII characters.
| profileId  | String| The profile_id of the profile you wish the calendar to be added to. This ID should have been discovered by making a list calendars request.
| name       | String| The String to use as the name of the calendar.

## Cronofy.getFreeBusyCalendarsInfo
Returns a list of free-busy information across all of a users calendars. By default, the events you are managing on behalf of the account are excluded from the query results. The returned free-busy periods will start before the given to Date and will end on or after the given from Date. Note that the events you manage are not subject to the default from and to date restrictions and so if you specify neither, you will retrieve all the events you are managing for the account across all of time.

| Field         | Type      | Description
|---------------|-----------|----------
| accessToken   | String    | The new Access Token to use to authenticate when using the API on behalf of the user.Will always be a 32 character String of ASCII characters.
| from          | DatePicker| The minimum Date from which to return free-busy information.If not provided, defaults to the minimum value of 42 days in the past.
| to            | DatePicker| The Date to return free-busy information up until.If not provided, defaults to the maximum value of 201 days in the future.Note that the results will not include events occurring on this date.
| tzid          | String    | A String representing a known time zone identifier from the [IANA Time Zone Database](http://www.iana.org/time-zones).Example - Europe/Paris.
| includeManaged| Select    | A Boolean specifying whether events that you are managing for the account should be included or excluded from the results.If not provided, only non-managed events are returned.Note that the events you manage are not subject to the default from and to date restrictions and so if you specify neither, you will retrieve all the events you are managing for the account across all of time.
| calendarIds   | List      | Restricts the returned free-busy information to that within the set of specified calendar_ids.
| localizedTimes| Select    | A Boolean specifying whether the free-busy periods should have their start and end times returned with any available localization information.If not provided the start and end times will be returned as simple Time values.

##### tzid 

A String representing a known time zone identifier from the [IANA Time Zone Database](http://www.iana.org/time-zones).
Common examples are:
- Etc/UTC
- Europe/Paris
- America/Chicago
It is recommended that you use the same tzid for all requests made for an individual user in order to ensure all their events are returned to you.


## Cronofy.readEvents
Returns a list of events across all of a users calendars.By default, the events you are managing on behalf of the account are excluded from the query results.The returned events will start before the given to Date and will end on or after the given from Date.Note that the events you manage are not subject to the default from and to date restrictions and so if you specify neither, you will retrieve all the events you are managing for the account across all of time.

| Field         | Type      | Description
|---------------|-----------|----------
| accessToken   | String    | The new Access Token to use to authenticate when using the API on behalf of the user.Will always be a 32 character String of ASCII characters.
| from          | DatePicker| The minimum Date from which to return free-busy information.If not provided, defaults to the minimum value of 42 days in the past.
| to            | DatePicker| The Date to return free-busy information up until.If not provided, defaults to the maximum value of 201 days in the future.Note that the results will not include events occurring on this date.
| tzid          | String    | A String representing a known time zone identifier from the [IANA Time Zone Database](http://www.iana.org/time-zones).Example - Europe/Paris.
| includeManaged| Select    | A Boolean specifying whether events that you are managing for the account should be included or excluded from the results.If not provided, only non-managed events are returned.Note that the events you manage are not subject to the default from and to date restrictions and so if you specify neither, you will retrieve all the events you are managing for the account across all of time.
| includeDeleted| Select    | A Boolean specifying whether events that have been deleted should included or excluded from the results.If not provided, only non-deleted events are returned.
| includeMoved  | Select    | A Boolean specifying whether events that have ever existed within the given window should be included or excluded from the results.If not provided, only events that are currently within the search period are returned.
| lastModified  | DatePicker| The Time that events must be modified on or after in order to be returned.If not provided, all events are returned regardless of when they were last modified.
| onlyManaged   | Select    | A Boolean specifying whether only events that you are managing for the account should be included in the results.Note that the events you manage are not subject to the default from and to date restrictions and so if you specify neither, you will retrieve all the events you are managing for the account across all of time.
| includeGeo    | Select    | A Boolean specifying whether the events should have their location.lat and location.long returned where available.Verified applications must have geo-location included in their plan or the API call will result in a 402 error.
| calendarIds   | List      | Restricts the returned free-busy information to that within the set of specified calendar_ids.
| localizedTimes| Select    | A Boolean specifying whether the free-busy periods should have their start and end times returned with any available localization information.If not provided the start and end times will be returned as simple Time values.

##### localizedTimes

A Boolean specifying whether the events should have their start and end times returned with any available localization information.
If not provided the start and end times will be returned as simple Time values.

`The localized times are extracted on a best-effort basis from the underlying providers. We do not receive time zone information from all providers and so their events will always be returned with a time zone identifier of Etc/UTC.
 As providers expose this data, or we implement deeper integrations with their platforms, the time zone data available to you will be improved without changes being required to your code.`

##### tzid 

A String representing a known time zone identifier from the [IANA Time Zone Database](http://www.iana.org/time-zones).
Common examples are:
- Etc/UTC
- Europe/Paris
- America/Chicago
It is recommended that you use the same tzid for all requests made for an individual user in order to ensure all their events are returned to you.

## Cronofy.createEvents
Creates an event within a user's calendar.

| Field       | Type  | Description
|-------------|-------|----------
| accessToken | String| The new Access Token to use to authenticate when using the API on behalf of the user.Will always be a 32 character String of ASCII characters.
| calendarId  | String| The calendar_id of the calendar you wish the event to be added to. This ID should have been discovered by making a list calendars request and must not have a calendar_readonly or calendar_deleted value that is true.
| eventId     | String| Id of the event you wish to push into the user's selected calendar.
| summary     | String| Summary of the event you wish to push into the user's selected calendar.
| transparency| Select| A String value representing the transparency of the event.`opaque` - the account should appear as busy for the duration of the event.`transparent` - the account should not appear as busy for the duration of the event.If not provided, transparent is used for all-day events, and opaque for Time-based events.
| description | String| The String to use as the description, sometimes referred to as the notes, of the event.
| eventStart  | JSON  | The start time can be provided as a simple Time or Date string or an object with two attributes, time and tzid.
| eventEnd    | JSON  | The end time can be provided as a simple Time or Date string or an object with two attributes, time and tzid.
| tzid        | String| The timezone to render the event with.The start and end parameters should be omited.Example - Europe/Paris.
| reminders   | Array | You can provide an array of up to 5 reminders for an event. They should be provided in order of priority for your application, not time order. This is because the providers support a varying number of reminders and we will set as many as they allow, in the order you provide them.
| url         | String| A String value which must be parseable as a URI as defined as defined in RFC 1738 and RFC 2111.Omitting the value will leave the URL unchanged. Setting the value to null will remove the URL if supported by the provider.Support for event URLs is currently limited to Apple and Google. Please note there is an issue with Google whereby URLs are not removable once they are provided.

##### reminders

You can provide an array of up to 5 reminders for an event. They should be provided in order of priority for your application, not time order. This is because the providers support a varying number of reminders and we will set as many as they allow, in the order you provide them.
Number of reminders supported per provider:

- Apple 5 reminders, note that icloud.com will only display two
- Exchange 1 reminder
- Google 5 reminders
- Office 365 1 reminder
- Outlook.com 1 reminder

For example, if you provide 3 reminders and the provider only supports one, we will use the first one you specify, not the earliest or the latest one.
As a concrete example, whilst we advise erring on the side of setting less reminders rather than more, it is easy to imagine that 3 reminders may be useful for an appointment:
30 minutes before event start - get to the appointment;
24 hours before event start - remember about the appointment;
At event start - the appointment should have started;


##### eventStart/EventEnd
When localized_times is not specified or is false, the Time or Date representing when the free-busy period starts.
When localized_times is true, an object with two attributes, time and tzid : 
```
{
     "time": "2014-09-13T23:00:00+02:00",
     "tzid": "Europe/Paris"
}
   ```
The time attribute is the Time or Date representing when the free-busy period starts. This will be provided with an offset matching that of the corresponding tzid.
The tzid attribute specifies a String representing a known time zone identifier from the [IANA Time Zone Database](http://www.iana.org/time-zones).

Common examples are - 
- Etc/UTC
- Europe/Paris
- America/

##### tzid 

A String representing a known time zone identifier from the [IANA Time Zone Database](http://www.iana.org/time-zones).
Common examples are:
- Etc/UTC
- Europe/Paris
- America/Chicago
It is recommended that you use the same tzid for all requests made for an individual user in order to ensure all their events are returned to you.


## Cronofy.updateEvents
Update an event within a user's calendar.

| Field       | Type  | Description
|-------------|-------|----------
| accessToken | String| The new Access Token to use to authenticate when using the API on behalf of the user.Will always be a 32 character String of ASCII characters.
| calendarId  | String| The calendar_id of the calendar you wish the event to be added to. This ID should have been discovered by making a list calendars request and must not have a calendar_readonly or calendar_deleted value that is true.
| eventId     | String| Id of the event you wish to push into the user's selected calendar.
| summary     | String| Summary of the event you wish to push into the user's selected calendar.
| transparency| Select| A String value representing the transparency of the event.`opaque` - the account should appear as busy for the duration of the event.`transparent` - the account should not appear as busy for the duration of the event.If not provided, transparent is used for all-day events, and opaque for Time-based events.
| description | String| The String to use as the description, sometimes referred to as the notes, of the event.
| eventStart  | JSON  | The start time can be provided as a simple Time or Date string or an object with two attributes, time and tzid.
| eventEnd    | JSON  | The end time can be provided as a simple Time or Date string or an object with two attributes, time and tzid.
| tzid        | String| The timezone to render the event with.The start and end parameters should be omited.Example - Europe/Paris.
| reminders   | Array | You can provide an array of up to 5 reminders for an event. They should be provided in order of priority for your application, not time order. This is because the providers support a varying number of reminders and we will set as many as they allow, in the order you provide them.
| url         | String| A String value which must be parseable as a URI as defined as defined in RFC 1738 and RFC 2111.Omitting the value will leave the URL unchanged. Setting the value to null will remove the URL if supported by the provider.Support for event URLs is currently limited to Apple and Google. Please note there is an issue with Google whereby URLs are not removable once they are provided.

##### reminders

You can provide an array of up to 5 reminders for an event. They should be provided in order of priority for your application, not time order. This is because the providers support a varying number of reminders and we will set as many as they allow, in the order you provide them.
Number of reminders supported per provider:

- Apple 5 reminders, note that icloud.com will only display two
- Exchange 1 reminder
- Google 5 reminders
- Office 365 1 reminder
- Outlook.com 1 reminder

For example, if you provide 3 reminders and the provider only supports one, we will use the first one you specify, not the earliest or the latest one.
As a concrete example, whilst we advise erring on the side of setting less reminders rather than more, it is easy to imagine that 3 reminders may be useful for an appointment:
30 minutes before event start - get to the appointment;
24 hours before event start - remember about the appointment;
At event start - the appointment should have started;


##### eventStart/EventEnd
When localized_times is not specified or is false, the Time or Date representing when the free-busy period starts.
When localized_times is true, an object with two attributes, time and tzid : 
```
{
     "time": "2014-09-13T23:00:00+02:00",
     "tzid": "Europe/Paris"
}
   ```
The time attribute is the Time or Date representing when the free-busy period starts. This will be provided with an offset matching that of the corresponding tzid.
The tzid attribute specifies a String representing a known time zone identifier from the [IANA Time Zone Database](http://www.iana.org/time-zones).

Common examples are - 
- Etc/UTC
- Europe/Paris
- America/

##### tzid 

A String representing a known time zone identifier from the [IANA Time Zone Database](http://www.iana.org/time-zones).
Common examples are:
- Etc/UTC
- Europe/Paris
- America/Chicago
It is recommended that you use the same tzid for all requests made for an individual user in order to ensure all their events are returned to you.


## Cronofy.deleteEvent
Creates a calendar within a user's profile.In order for this to be possible, you must request the create_calendar scope when requesting authorization to access the user's calendars.

| Field      | Type  | Description
|------------|-------|----------
| accessToken| String| The new Access Token to use to authenticate when using the API on behalf of the user.Will always be a 32 character String of ASCII characters.
| calendarId | String| The calendar_id of the calendar you wish the event to be added to. This ID should have been discovered by making a list calendars request and must not have a calendar_readonly or calendar_deleted value that is true.
| eventId    | String| Id of the event you wish to push into the user's selected calendar.

## Cronofy.deleteAllEvents
Delete events that you are managing from the user's calendars in bulk.

| Field      | Type  | Description
|------------|-------|----------
| accessToken| String| The new Access Token to use to authenticate when using the API on behalf of the user.Will always be a 32 character String of ASCII characters.

## Cronofy.deleteAllEventsBuCalendarId
Delete all events from specific calendars.

| Field      | Type  | Description
|------------|-------|----------
| accessToken| String| The new Access Token to use to authenticate when using the API on behalf of the user.Will always be a 32 character String of ASCII characters.
| calendarIds| List  | An List specifying the calendars from which to delete all events you are managing for the user. When provided at least one calendar must be specified.

## Cronofy.editParticipationStatus
Changes the status of a user's participation in an event.In order for this to be possible, you must request the change_participation_status scope when requesting authorization to access the user's calendars.If an invite is declined in Office 365 or Exchange the event is implicitly deleted in the calendar and so will not be able to be modified again.

| Field      | Type  | Description
|------------|-------|----------
| accessToken| String| The new Access Token to use to authenticate when using the API on behalf of the user.Will always be a 32 character String of ASCII characters.
| calendarId | String| The calendar_id of the calendar that contains the event for which you'd like to update the participation status. This ID can be retrieved using a list calendars requestThis calendar must not have a calendar_readonly value that is true.
| eventId    | String| The String that uniquely identifies the event. This ID can be retrieved using the read events request.This event must be have its options.change_participation_status flag set to true.
| status     | Select| A String representing the participation status you'd like to set. Acceptable values are:accepted - to accept the invite;tentative - to tentatively accept the invite;declined - to decline the invite;

## Cronofy.deleteExternalEvent
Deletes an externally managed event from a user's calendar.In order to make this call, you must request elevated access to access the user's calendars. Then, the event itself must be have its options.delete flag set to true.

| Field      | Type  | Description
|------------|-------|----------
| accessToken| String| The new Access Token to use to authenticate when using the API on behalf of the user.Will always be a 32 character String of ASCII characters.
| calendarId | String| The calendar_id of the calendar that contains the event for which you'd like to update the participation status. This ID can be retrieved using a list calendars requestThis calendar must not have a calendar_readonly value that is true.
| eventId    | String| The String that uniquely identifies the event. The combination of calendar_id and event_uid combination will be used to delete the event.This will be an ID retrieved as part of a read events request.

## Cronofy.editExternalEvent
In order to make this call, you must request elevated access to access the user's calendars. Then, the event itself must be have its options.update flag set to true.

| Field       | Type  | Description
|-------------|-------|----------
| accessToken | String| The new Access Token to use to authenticate when using the API on behalf of the user.Will always be a 32 character String of ASCII characters.
| calendarId  | String| The calendar_id of the calendar you wish the event to be added to. This ID should have been discovered by making a list calendars request and must not have a calendar_readonly or calendar_deleted value that is true.
| eventId     | String| Id of the event you wish to push into the user's selected calendar.
| summary     | String| Summary of the event you wish to push into the user's selected calendar.
| transparency| Select| A String value representing the transparency of the event.`opaque` - the account should appear as busy for the duration of the event.`transparent` - the account should not appear as busy for the duration of the event.If not provided, transparent is used for all-day events, and opaque for Time-based events.
| description | String| The String to use as the description, sometimes referred to as the notes, of the event.
| eventStart  | JSON  | The start time can be provided as a simple Time or Date string or an object with two attributes, time and tzid.
| eventEnd    | JSON  | The end time can be provided as a simple Time or Date string or an object with two attributes, time and tzid. 
| tzid        | String| The timezone to render the event with.The start and end parameters should be omited.Example - Europe/Paris.
| reminders   | Array | You can provide an array of up to 5 reminders for an event. They should be provided in order of priority for your application, not time order. This is because the providers support a varying number of reminders and we will set as many as they allow, in the order you provide them.
| url         | String| A String value which must be parseable as a URI as defined as defined in RFC 1738 and RFC 2111.Omitting the value will leave the URL unchanged. Setting the value to null will remove the URL if supported by the provider.Support for event URLs is currently limited to Apple and Google. Please note there is an issue with Google whereby URLs are not removable once they are provided.

##### reminders

You can provide an array of up to 5 reminders for an event. They should be provided in order of priority for your application, not time order. This is because the providers support a varying number of reminders and we will set as many as they allow, in the order you provide them.
Number of reminders supported per provider:

- Apple 5 reminders, note that icloud.com will only display two
- Exchange 1 reminder
- Google 5 reminders
- Office 365 1 reminder
- Outlook.com 1 reminder

For example, if you provide 3 reminders and the provider only supports one, we will use the first one you specify, not the earliest or the latest one.
As a concrete example, whilst we advise erring on the side of setting less reminders rather than more, it is easy to imagine that 3 reminders may be useful for an appointment:
30 minutes before event start - get to the appointment;
24 hours before event start - remember about the appointment;
At event start - the appointment should have started;

##### eventStart/EventEnd
When localized_times is not specified or is false, the Time or Date representing when the free-busy period starts.
When localized_times is true, an object with two attributes, time and tzid : 
```
{
     "time": "2014-09-13T23:00:00+02:00",
     "tzid": "Europe/Paris"
}
   ```
The time attribute is the Time or Date representing when the free-busy period starts. This will be provided with an offset matching that of the corresponding tzid.
The tzid attribute specifies a String representing a known time zone identifier from the [IANA Time Zone Database](http://www.iana.org/time-zones).

Common examples are - 
- Etc/UTC
- Europe/Paris
- America/

## Cronofy.createNotificationChannel
Creates a new channel for receiving notifications when changes occur.Notification channels can be created with additional filters which can be thought of as a subset of those available when reading events.

| Field      | Type  | Description
|------------|-------|----------
| accessToken| String| The new Access Token to use to authenticate when using the API on behalf of the user.Will always be a 32 character String of ASCII characters.
| callbackUrl| String| The HTTP or HTTPS URL you wish to receive push notifications.Must not be longer than 128 characters and should be HTTPS.
| calendarIds| List  | Restricts the notifications to changes to events within the specified calendars.The possible calendar_ids can be discovered through the list calendars endpoint.If omitted, notifications are sent for changes to events across all calendars. When specified, at least one calendar_id must be provided.
| onlyManaged| Select| A Boolean specifying whether only events that you are managing for the account should trigger notifications.

## Cronofy.getListNotificationChannels
Returns a list of all the authenticated user's notification channels.

| Field      | Type  | Description
|------------|-------|----------
| accessToken| String| The new Access Token to use to authenticate when using the API on behalf of the user.Will always be a 32 character String of ASCII characters.

## Cronofy.deleteNotificationChannel
Closes an existing push notification channel to stop notifications being sent.

| Field      | Type  | Description
|------------|-------|----------
| accessToken| String| The new Access Token to use to authenticate when using the API on behalf of the user.Will always be a 32 character String of ASCII characters.
| channelId  | String| The ID of the push notification channel you wish to close.

## Cronofy.getUserInfo
Returns identifying information for the authenticated account. This is defined as part of the OpenID spec.

| Field      | Type  | Description
|------------|-------|----------
| accessToken| String| The new Access Token to use to authenticate when using the API on behalf of the user.Will always be a 32 character String of ASCII characters.

## Cronofy.getAccountInformation
Returns identifying information for the authenticated account.

| Field      | Type  | Description
|------------|-------|----------
| accessToken| String| The new Access Token to use to authenticate when using the API on behalf of the user.Will always be a 32 character String of ASCII characters.

## Cronofy.getProfileInformation
Returns a list of all the authenticated user's calendar profiles.

| Field      | Type  | Description
|------------|-------|----------
| accessToken| String| The new Access Token to use to authenticate when using the API on behalf of the user.Will always be a 32 character String of ASCII characters.

