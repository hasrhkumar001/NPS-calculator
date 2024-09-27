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
    <table  border="1" style="border-collapse:collapse">
    <tr><th>Quality of Delivery</th> <td>{{ $surveyData['quality_of_delivery'] }}</td></tr>
    <tr><th>Quality of Responses</th> <td> {{ $surveyData['quality_of_responses'] }}</td></tr>
    <tr><th>Timeliness of Responses</th> <td> {{ $surveyData['timeliness_of_responses'] }}</td></tr>
    <tr><th>IT Support</th> <td> {{ $surveyData['it_support'] }}</td></tr>
    <tr><th>Project Management</th> <td> {{ $surveyData['project_management'] }}</td></tr>
    <tr><th>Use of Latest Tools/Technology</th> <td> {{ $surveyData['latest_tools'] }}</td></tr>
    <tr><th>Value for Money</th> <td> {{ $surveyData['value_for_money'] }}</td></tr>
    <tr><th>Overall Support</th> <td> {{ $surveyData['overall_support'] }}</td></tr>
    <tr><th>How likely are you to work with us again on other projects?</th> <td> {{ $surveyData['work_with_us_again'] }}</td></tr>

    <tr><th>Additional Comments </th> <td> {{ $surveyData['additional_comments'] }}</td></tr>
    </table>
</body>
</html>
