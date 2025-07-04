<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Community Family Tree</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Family Tree</a>
        <div class="d-flex align-items-center ms-auto">
            <a href="#" class="nav-link">Profile</a>
            <form method="POST" action="{{ route('logout') }}" class="d-inline ms-2">
                @csrf
                <button type="submit" class="btn btn-outline-danger btn-sm">Logout</button>
            </form>
        </div>
    </div>
</nav>
<div class="container mt-4">
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Your Profile</div>
                <div class="card-body">
                    <p><strong>Name:</strong> {{ $user->name }}</p>
                    <p><strong>Email:</strong> {{ $user->email }}</p>
                    <p><strong>Phone:</strong> {{ $user->phone }}</p>
                    <p><strong>City:</strong> {{ $user->city }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h5 class="mb-0">Family Members</h5>
                <a href="{{ route('family-members.create') }}" class="btn btn-primary">Add Family Member</a>
            </div>
            <div class="card">
                <div class="card-body">
                    <table id="family-members-table" class="table table-striped table-bordered dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Relationship</th>
                                <th>Age</th>
                                <th>City</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($familyMembers as $member)
                            <tr>
                                <td>{{ $member->name }}</td>
                                <td>{{ $member->relationship }}</td>
                                <td>{{ $member->age ?? 'N/A' }}</td>
                                <td>{{ $member->city ?? 'N/A' }}</td>
                                <td>
                                    <a href="{{ route('family-members.edit', $member) }}" class="btn btn-sm btn-warning me-2">Edit</a>
                                    <form action="{{ route('family-members.destroy', $member) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this family member?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">Family Tree</div>
                <div class="card-body">
                    <div id="family-tree" style="width:100%; min-height:400px;"></div>
                </div>
            </div>
        </div>
    </div>
    @if(isset($otherUserTrees) && count($otherUserTrees) > 0)
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">Community Family Trees</div>
                <div class="card-body">
                    <div class="row">
                        @foreach($otherUserTrees as $idx => $otherTree)
                        <div class="col-md-6 mb-4">
                            <div class="border rounded p-2">
                                <div id="community-tree-{{ $idx }}" style="width:100%; min-height:300px;"></div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
<script>
    $(document).ready(function() {
        $('#family-members-table').DataTable({
            responsive: true
        });
        // Treant.js tree config from backend
        var treeData = @json($tree);
        console.log(treeData); // Debug
        new Treant({
            chart: {
                container: "#family-tree",
                node: { collapsable: true },
                animation: { nodeAnimation: "easeOutBounce", nodeSpeed: 700, connectorsAnimation: "bounce", connectorsSpeed: 700 },
                callback: {
                    onCreateNode: function(node, data) {
                        if (data.data && data.data.isDirect) {
                            var info = '';
                            if (data.data.phone) info += '<div><small>Phone: ' + data.data.phone + '</small></div>';
                            if (data.data.email) info += '<div><small>Email: ' + data.data.email + '</small></div>';
                            $(node).find('.node-name').after(info);
                        }
                    }
                }
            },
            nodeStructure: treeData
        });
        // Render community user trees (only name and city)
        @if(isset($otherUserTrees) && count($otherUserTrees) > 0)
            @foreach($otherUserTrees as $idx => $otherTree)
                new Treant({
                    chart: {
                        container: "#community-tree-{{ $idx }}",
                        node: { collapsable: true },
                        animation: { nodeAnimation: "easeOutBounce", nodeSpeed: 700, connectorsAnimation: "bounce", connectorsSpeed: 700 },
                    },
                    nodeStructure: @json($otherTree)
                });
            @endforeach
        @endif
    });
</script>
<!-- Treant.js CSS/JS (CDN for demo) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/treant-js/1.0/Treant.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/treant-js/1.0/vendor/perfect-scrollbar.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.3.0/raphael.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/treant-js/1.0/vendor/perfect-scrollbar.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/treant-js/1.0/Treant.min.js"></script>
</body>
</html>
