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

    @for ($i = 1; $i <= 9; $i++)
        @if(isset($questions[$i]))
       
        <tr align="left">
            <th>{{ $questions[$i] }}</th>
            <td>{{ $surveyData["response_{$i}"] }}</td> 
        </tr>
        @endif
    @endfor

    <tr><th>Additional Comments </th> <td> {{ $surveyData['additional_comments'] }}</td></tr>
    </table>
</body>
</html>
