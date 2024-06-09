 <!--datatable css-->
 <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css" />
 <!--datatable responsive css-->
 <link href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" rel="stylesheet"
     type="text/css" />
 <link href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />

 <style>
     table {
         font-size: 0.8rem;
     }

     .main-table th h1 {
         font-weight: bold;
         font-size: 1em;
         text-align: left;
         color: #185875;
     }

     .main-table td {
         font-weight: normal;
         font-size: 1em;
         -webkit-box-shadow: 0 2px 2px -2px #dbe0ff;
         -moz-box-shadow: 0 2px 2px -2px #dbe0ff;
         box-shadow: 0 2px 2px -2px #dbe0ff;
     }

     .main-table {
         text-align: left;
         overflow: hidden;
         width: 80%;
         margin: 0 auto;
         display: table;
     }

     .main-table thead {
         background-color: #5869d8;
         color: white;
     }

     .main-table td,
     .main-table th {
         padding-bottom: 2%;
         padding-top: 2%;
         padding-left: 2%;
     }

     /* Background-color of the odd rows */
     /* .main-table tr:nth-child(odd) {
                                background-color: white;
                            } */

     /* Background-color of the even rows */
     /* .main-table tr:nth-child(even) {
                                background-color: rgb(237, 237, 237);
                            } */

     .main-table th {
         background-color: #1F2739;
     }

     .main-table td:first-child {
         color: #8c0013;
         font-weight: bold;
     }

     .main-table tbody tr:hover {
         background-color: #dbe0ff;
         -webkit-box-shadow: 0 6px 6px -6px #dbe0ff;
         -moz-box-shadow: 0 6px 6px -6px #dbe0ff;
         box-shadow: 0 6px 6px -6px #dbe0ff;
     }

     .main-table td:hover {
         background-color: white;
         color: #403E10;
         font-weight: bold;

         box-shadow: grey -1px 1px, grey -2px 2px, grey -3px 3px, grey -4px 4px, grey -5px 5px, grey -6px 6px;
         transform: translate3d(6px, -6px, 0);

         transition-delay: 0s;
         transition-duration: 0.4s;
         transition-property: all;
         transition-timing-function: line;
     }

     @media (max-width: 800px) {

         .main-table td:nth-child(4),
         .main-table th:nth-child(4) {
             display: none;
         }
     }
 </style>
