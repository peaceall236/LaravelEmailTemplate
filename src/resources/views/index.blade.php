<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <title>Email Templates</title>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ol class="breadcrumb">
                    <li><a href="#">Dashboard</a></li>
                    <li class="active">Email Templates</li>
                </ol>
            </div>
            <div class="col-md-12 text-center">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="list-unstyled">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if (Session::has('status'))
                    <div class="alert alert-success">{{ Session::get('status') }}</div>
                @endif
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">On-queue <span class="badge badge-secondary"> {{ $on_queue }} </span></div>
                            <div class="panel-body">
                                @if ($on_queue <= 0)
                                    None!
                                @else
                                    <table class="table">
                                        <tr>
                                            <th>Template</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    @foreach ($uploads as $upload)
                                        <tr>
                                            <td> {{ $upload->name }} </td>
                                            <td> {{ $upload->status }} </td>
                                            <td>
                                                @switch($upload->status)
                                                    @case($retry_status)
                                                        <a href=" {{ route('laravelemailtemplate.retry', ['id' => $upload->id]) }} " class="btn btn-danger btn-xs">
                                                            retry
                                                        </a>
                                                        @break
                                                    @default
                                                        
                                                @endswitch
                                            </td>
                                        </tr>
                                    @endforeach
                                    </table>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <h2>Templates</h2>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Placeholders</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="templateListBody"></tbody>
                </table>
            </div>

            <div class="col-md-6">
                <div class="hidden" id="templateEdit">
                    <form method="POST" enctype="multipart/form-data" action="{{ route('laravelemailtemplate.store') }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="templateZip" >Selected template: <span id="templateNamePlaceHolder"></span></label>
                            <input type="file" id="templateZip" name="templateZip">
                            <p class="help-block">Allowed files: .zip </p>
                        </div>
                        <div class="form-group">
                            <label for="entryFileName">Entry file</label>
                            <input type="text" class="form-control" id="entryFileName" name="entryFileName" placeholder="Example: email.html">
                        </div>
                        <input type="hidden" name="templateIndex" id="templateIndex">
                        <button type="submit" class="btn btn-primary btn-sm">Upload Template</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        var template_list = @json($templates);
        var template_id = "templateEdit";

        template_list.forEach(function (template, template_index) {
            var row = document.createElement("tr");

            // numbering column
            var count_col = document.createElement("td");
            count_col.textContent = template_index + 1;
            row.appendChild(count_col);

            // name column contents
            var name = document.createElement("td");
            name.textContent = template.name;
            row.appendChild(name);

            // placeholder column contents
            var placeholders = document.createElement("td");
            template.variables.forEach(function(variable) {
                var variable_span = document.createElement("span");
                variable_span.classList.add("badge", "badge-secondary");
                variable_span.textContent = "$" + variable;
                placeholders.appendChild(variable_span);
            });
            row.appendChild(placeholders);

            // action column contents
            var action = document.createElement("td");
            var actionBtn = document.createElement("button")
            actionBtn.classList.add("btn", "btn-success", "btn-sm", "text-uppercase");
            actionBtn.textContent = "Modify";
            actionBtn.type = "button"

            // Modify Button Action
            actionBtn.addEventListener('click', function (e) {
                updateTemplate(template_index, template_id);
            });
            action.appendChild(actionBtn);
            row.appendChild(action);

            // append row to table body
            document.getElementById("templateListBody").appendChild(row);
        });

        function updateTemplate(index, templateId) {
            var templateDiv = document.getElementById(templateId);
            if (templateDiv.classList.contains("hidden")) {
                templateDiv.classList.remove("hidden");
            }

            document.getElementById("templateNamePlaceHolder").innerHTML = template_list[index].name;

            document.getElementById("templateIndex").value = index;
        }
    </script>
</body>
</html>