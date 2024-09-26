<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Satisfaction Survey</title>
</head>
<body>
    <h2>Customer Satisfaction Survey</h2>
    <p><strong>NPS:</strong> {{ $surveyData['nps'] }}%</p>
    <p><strong>Project Name:</strong> {{ $surveyData['project_name'] }}</p>
    <p><strong>IDS Lead/Manager:</strong> {{ $surveyData['ids_lead'] }}</p>
    <p><strong>Client Organization:</strong> {{ $surveyData['client_organization'] }}</p>
    <p><strong>Client Contact Name:</strong> {{ $surveyData['client_contact_name'] }}</p>
    <p><strong>Email Sent Date:</strong> {{ $surveyData['email_sent_date'] }}</p>
    <p><strong>Survey Date:</strong> {{ $surveyData['survey_date'] }}</p>
    <p><strong>CSAT:</strong> Quarterly</p>

    <p><strong>Quality of Delivery:</strong> {{ $surveyData['quality_of_delivery'] }}</p>
    <p><strong>Quality of Responses:</strong> {{ $surveyData['quality_of_responses'] }}</p>
    <p><strong>Timeliness of Responses:</strong> {{ $surveyData['timeliness_of_responses'] }}</p>
    <p><strong>IT Support:</strong> {{ $surveyData['it_support'] }}</p>
    <p><strong>Project Management:</strong> {{ $surveyData['project_management'] }}</p>
    <p><strong>Use of Latest Tools/Technology:</strong> {{ $surveyData['latest_tools'] }}</p>
    <p><strong>Value for Money:</strong> {{ $surveyData['value_for_money'] }}</p>
    <p><strong>Overall Support:</strong> {{ $surveyData['overall_support'] }}</p>
    <p><strong>How likely are you to work with us again on other projects?</strong> {{ $surveyData['work_with_us_again'] }}</p>

    <p><strong>Additional Comments:</strong> {{ $surveyData['additional_comments'] }}</p>
</body>
</html>
