<?php
$routes = [
    'metadata',
    'getAccessToken',
    'refreshAccessToken',
    'revokeAccessToken',
    'extendedPermissions',
    'getCalendarsPeriods',
    'getRealTimeSchedulingUrl',
    'createCalendarAccessUrl',
    'getListCalendars',
    'createCalendar',
    'getFreeBusyCalendarsInfo',
    'readEvents',
    'createEvents',
    'updateEvents',
    'deleteEvent',
    'deleteAllEvents',
    'deleteAllEventsBuCalendarId',
    'editParticipationStatus',
    'deleteExternalEvent',
    'editExternalEvent',
    'createNotificationChannel',
    'getListNotificationChannels',
    'deleteNotificationChannel',
    'getUserInfo',
    'getAccountInformation',
    'getProfileInformation',
    'webhookEvent'
];
foreach($routes as $file) {
    require __DIR__ . '/../src/routes/'.$file.'.php';
}

