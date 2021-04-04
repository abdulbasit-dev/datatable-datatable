<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport"
    content="width=device-width, initial-scale=1">

  <title>Laravel</title>

  {{-- bootsrtap --}}
  <link rel="stylesheet"
    href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" />

  {{-- datatable --}}
  <link rel="stylesheet"
    type="text/css"
    href="https://cdn.datatables.net/v/dt/jq-3.3.1/dt-1.10.24/sb-1.0.1/sp-1.2.2/sl-1.3.3/datatables.min.css" />

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap"
    rel="stylesheet">

  <!-- Styles -->
  <style>
    html,
    body {
      background-color: #fff;
      color: #414446;
      font-family: 'Nunito', sans-serif;
      font-weight: 400;
      height: 100vh;
      margin: 0;
    }

    .title {
      font-size: 60px;
    }

  </style>
</head>

<body>
  <div class="container">

    <div class="title text-center mt-3 mb-5">
      Laravel DataTable
    </div>




    <form id="form"
      class="mb-4">
      <div class="form-row">
        <div class="col-md-3 mb-3">
          <label for="sortBy">Select A Gender</label>
          <select id="sortBy"
            class="form-control">
            <option value="">Select Gender</option>
            @foreach ($genders as $gender)
              <option value="{{ $gender->gender }}">{{ $gender->gender }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-3 mb-3">
          <label for="age">Age</label>
          <input type="number"
            placeholder="Age"
            class="form-control"
            id="age">
        </div>
        <div class="col-md-3 mb-3">
          <label for="validatiponCustom04">City</label>
          <select id="city"
            class="form-control">
            <option value="">Select A City</option>
            @foreach ($cities as $city)
              <option value="{{ $city->address }}">{{ $city->address }}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="form-row">
        <div class="col-md-9 mb-3">
          <label for="minSalary">Salary Rang</label>
          <div class="d-flex">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text"
                  id="inputGroupPrepend">Min Salary ${{ $minSalary }}</span>
              </div>
              <input type="number"
                class="form-control"
                id="minSalary"
                placeholder="Enater min salary" />
            </div>
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text"
                  id="inputGroupPrepend">Max Salary ${{ $maxSalary }}</span>
              </div>
              <input type="number"
                class="form-control"
                id="maxSalary"
                placeholder="Enater max salary" />
            </div>
          </div>
        </div>

      </div>
      <button class="btn btn-primary"
        type="submit">Submit form</button>

    </form>






    <table class="table table-bordered table-hover"
      id="example">
      <thead>
        <tr>
          <th class="text-center">id</th>
          <th class="text-center">Customer Info</th>
          <th class="text-center">Photo</th>
          <th class="text-center">Salary</th>
          <th class="text-center">Contact Contact</th>
        </tr>
      </thead>
      <tbody class="text-center">

      </tbody>

    </table>
  </div>





  <script src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
    crossorigin="anonymous"></script>
  <script type="text/javascript"
    src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>

  <script>
    // Initialize DataTables API object and configure table
    var table = $('#example').DataTable({
      "searching": true,
      "processing": true,
      "serverSide": true,
      "ajax": {
        "url": "{{ route('ajax') }}",
        "data": function(d) {
          d.gender = $("#sortBy").val()
          d.age = $("#age").val()
          d.minSalary = $("#minSalary").val()
          d.maxSalary = $("#maxSalary").val()
          d.city = $("#city").val()

        }
      },

      columnDefs: [{
          render: function(data, type, row) {
            return `
                <div class="d-flex justify-content-center mt-5 " >
                <p class="font-weight-bold">${row['id']}</p>
                </div>

                  `;
          },
          targets: 0,
          ordering: false,
        },
        {
          render: function(data, type, row) {
            return `
                <div  class="p-3">
                  <div>
                    <label for="" class="text-dark font-weight-bold mr-2">First Name:</label>
                    ${row["first_name"]}
                  </div>
                  <div>
                    <label for="" class="text-dark font-weight-bold mr-2">Last Name:</label>
                    ${row['last_name']}
                  </div>
                  <div class="d-flex justify-content-center">
                  <label for="" class="text-dark font-weight-bold mr-2">Gender:</label>
                 <div class=" text-${
                   row['gender'] === 'Male' ? 'primary' : 'success'
                 }">${row["gender"]}</div>
                  </div>
                  <div>
                    <label for="" class="text-dark font-weight-bold mr-2">Age:</label>
                    ${row['age']}
                  </div>
                </div>
                  `;
          },
          targets: 1,
          ordering: false,
        },
        {
          render: function(data, type, row) {
            return `

                <img src="https://images.pexels.com/photos/220453/pexels-photo-220453.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=100&h=100" class="mt-4" alt="profile image" class="">
                  `;
          },
          targets: 2,
        },
        {
          render: function(data, type, row) {
            return `


            <p class="mt-5">$${row['salary']}</p>
                  `;
          },
          targets: 3,
        },

        {
          render: function(data, type, row) {
            return `
                  <div  class="p-3">
                  <div>
                    <label for="" class="text-dark font-weight-bold mr-2">Email:</label>
                    ${row["email"]}
                  </div>
                  <div>
                    <label for="" class="text-dark font-weight-bold mr-2">Phone:</label>
                    ${row["phone"]}
                  </div>
                  <div>
                    <label for="" class="text-dark font-weight-bold mr-2">Address:</label>
                    ${row["address"]}
                  </div>

                </div>

                `;
          },
          targets: 4,
          visible: true,
        },
        // {
        //   render: function(data, type, row) {
        //     return `
        //     <div class="mt-4">
        //     <a href=""></a>
        //         <button class="btn btn-sm btn-outline-info">Edit</button>
        //         <button class="btn btn-sm btn-outline-danger">Delete</button>
        //     </div>
        //         `;
        //   },
        //   targets: 5,
        //   visible: true,
        // },

      ],
    });

    $(document).ready(function() {
      // Redraw the table
      //   table.draw();

      // Redraw the table based on the custom input
      //   $('#searchInput,#sortBy').bind("keyup change", function() {
      //     table.draw();
      //   });

      //   $('#sortBy,#age').change(function() {
      //     table.draw();
      //     $("#age").val('')
      //   });

      $("#form").submit(function(event) {
        table.draw();
        $("#age").val('')
        $("#sortBy").val('')
        event.preventDefault();
      });
    });

  </script>

</body>

</html>
