<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Community Family Tree</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/treant-js/1.0/Treant.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/treant-js/1.0/vendor/perfect-scrollbar.min.css" />
    <style>
        #community-tree { width: 100%; min-height: 600px; }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('dashboard') }}">Family Tree</a>
        <div class="d-flex align-items-center ms-auto">
            <a href="{{ route('dashboard') }}" class="nav-link">Dashboard</a>
            <form method="POST" action="{{ route('logout') }}" class="d-inline ms-2">
                @csrf
                <button type="submit" class="btn btn-outline-danger btn-sm">Logout</button>
            </form>
        </div>
    </div>
</nav>
<div class="container mt-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">Community Family Tree</div>
                <div class="card-body">
                    <div id="community-tree"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.3.0/raphael.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/treant-js/1.0/vendor/perfect-scrollbar.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/treant-js/1.0/Treant.min.js"></script>
<script>
    $(document).ready(function() {
        var communityTreeData = @json($communityTree);
        // If there are multiple root users, wrap in a fake root for Treant.js
        var treeConfig = {
            chart: {
                container: "#community-tree",
                node: { collapsable: true },
                animation: { nodeAnimation: "easeOutBounce", nodeSpeed: 700, connectorsAnimation: "bounce", connectorsSpeed: 700 },
                callback: {
                    onCreateNode: function(node, data) {
                        if (data.data && data.data.isDirect) {
                            var info = '';
                            if (data.data.phone) info += '<div><small>Phone: ' + data.data.phone + '</small></div>';
                            if (data.data.email) info += '<div><small>Email: ' + data.data.email + '</small></div>';
                            $(node).find('.node-name').after(info);
                        } else if (data.data && data.data.isDescendant) {
                            var masked = '<div><small>Phone: Masked</small></div><div><small>Email: Masked</small></div>';
                            $(node).find('.node-name').after(masked);
                        }
                    }
                }
            },
            nodeStructure: (communityTreeData.length === 1 ? communityTreeData[0] : { text: { name: 'Community' }, children: communityTreeData })
        };
        new Treant(treeConfig);
    });
</script>
</body>
</html> 