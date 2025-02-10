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
    <tr><th>Accessible and responsive to employee requests and concerns - Timeliness of Responses & Issue Resolution</th> <td>{{ $surveyData['response_1'] }}</td></tr>
    <tr><th>Understands and addresses BU needs timely & effectively. Supports with data-based inputs</th> <td> {{ $surveyData['response_2'] }}</td></tr>
    <tr><th>HR strategy and approach is aligned with Business Objectives</th> <td> {{ $surveyData['response_3'] }}</td></tr>
    <tr><th>HR/TA team understands critical talent requirement and hiring needs are met in line with BU requirements</th> <td> {{ $surveyData['response_4'] }}</td></tr>
    <tr><th>Advocates effectively for employee needs and concerns</th> <td> {{ $surveyData['response_5'] }}</td></tr>
    <tr><th>Helps with learning & development opportunities for employee in line with business requirements</th> <td> {{ $surveyData['response_6'] }}</td></tr>
    <tr><th>Ensure proactive communication & research-based inputs to each business unit</th> <td> {{ $surveyData['response_7'] }}</td></tr>
    <tr><th>Create opportunities for meaningful employee engagement and participation</th> <td> {{ $surveyData['response_8'] }}</td></tr>
    <tr><th>HR contributes effectively to the overall success of the BU and the organization</th> <td> {{ $surveyData['response_9'] }}</td></tr>

    <tr><th>Additional Comments </th> <td> {{ $surveyData['additional_comments'] }}</td></tr>
    </table>
</body>
</html>
