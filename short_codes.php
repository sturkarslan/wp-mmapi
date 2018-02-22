<?php

/**********************************************************************
 * Custom Short codes
 * Render the custom fields by interfacting with the web service
 **********************************************************************/

function summary_shortcode($attr, $content=null)
{
    $source_url = get_option('source_url', '');
    $summary_json = file_get_contents($source_url . "/api/v1.0.0/summary");
    $summary = json_decode($summary_json);
    $content = "<h2>Model Overview</h2>";
    $content .= "<table id=\"summary\" class=\"row-border\">";
    $content .= "  <thead><tr><th>#</th><th>Description</th></tr></thead>";
    $content .= "  <tbody>";
    $content .= "    <tr><td>" . $summary->num_biclusters . "</td><td>Biclusters</td></tr>";
    $content .= "    <tr><td>" . $summary->num_mutations . "</td><td>Mutations</td></tr>";
    $content .= "    <tr><td>" . $summary->num_regulators . "</td><td>Regulators</td></tr>";
    $content .= "  </tbody>";
    $content .= "</table>";
    $content .= "<script>";
    $content .= "  jQuery(document).ready(function() {";

    $content .= "    jQuery('#summary').DataTable({";
    $content .= "      'paging': false,";
    $content .= "      'info': false,";
    $content .= "      'searching': false";
    $content .= "    });";
    $content .= "  });";
    $content .= "</script>";
    return $content;
}


function mutation_table_shortcode($attr, $content=null)
{
    $mutation_name = get_query_var('mutation');
    $source_url = get_option('source_url', '');
    $result_json = file_get_contents($source_url . "/api/v1.0.0/mutation/" .
                                     rawurlencode($mutation_name));
    $entries = json_decode($result_json)->entries;

    $content = "";
    $content .= "<h3>Biclusters for Mutation <i>" . $mutation_name . "</i></h3>";
    $content .= "<table id=\"biclusters\" class=\"stripe row-border\">";
    $content .= "  <thead><tr><th>Bicluster</th><th>Regulator</th><th>Role</th></tr></thead>";
    $content .= "  <tbody>";
    foreach ($entries as $e) {
        $content .= "    <tr><td><a href=\"index.php/bicluster/?bicluster=" . $e->bicluster . "\">" . $e->bicluster . "</a></td><td><a href=\"index.php/regulator/?regulator=" . $e->regulator . "\">" . $e->regulator . "</a></td><td>" . $e->role . "</td></tr>";
    }
    $content .= "  </tbody>";
    $content .= "</table>";
    $content .= "<script>";
    $content .= "  jQuery(document).ready(function() {";
    $content .= "    jQuery('#biclusters').DataTable({";
    $content .= "    })";
    $content .= "  });";
    $content .= "</script>";
    return $content;
}


function regulator_table_shortcode($attr, $content=null)
{
    $regulator_name = get_query_var('regulator');
    $source_url = get_option('source_url', '');
    $result_json = file_get_contents($source_url . "/api/v1.0.0/regulator/" .
                                     rawurlencode($regulator_name));
    $entries = json_decode($result_json)->entries;
    $content = "";
    $content = "<h3>Biclusters for regulator " . $regulator_name . "</h3>";
    $content .= "<table id=\"biclusters\" class=\"stripe row-border\">";
    $content .= "  <thead><tr><th>Bicluster</th><th>Role</th></tr></thead>";
    $content .= "  <tbody>";
    foreach ($entries as $e) {
        $content .= "    <tr><td><a href=\"index.php/bicluster/?bicluster=" . $e->bicluster . "\">" . $e->bicluster . "</a></td><td>" . $e->role . "</td></tr>";
    }
    $content .= "  </tbody>";
    $content .= "</table>";
    $content .= "<script>";
    $content .= "  jQuery(document).ready(function() {";
    $content .= "    jQuery('#biclusters').DataTable({";
    $content .= "    })";
    $content .= "  });";
    $content .= "</script>";
    return $content;
}

function bicluster_genes_table_shortcode($attr, $content=null)
{
    $bicluster_name = get_query_var('bicluster');
    $source_url = get_option('source_url', '');
    $result_json = file_get_contents($source_url . "/api/v1.0.0/bicluster/" .
                                     rawurlencode($bicluster_name));
    $entries = json_decode($result_json)->genes;
    $content = "";
    $content = "<h3>Genes for bicluster " . $bicluster_name . "</h3>";
    $content .= "<table id=\"bc_genes\" class=\"stripe row-border\">";
    $content .= "  <thead><tr><th>Gene</th></tr></thead>";
    $content .= "  <tbody>";
    foreach ($entries as $e) {
        $content .= "    <tr><td><a href=\"index.php/gene-biclusters?gene=" . $e . "\">" . $e . "</a></td></tr>";
    }
    $content .= "  </tbody>";
    $content .= "</table>";
    $content .= "<script>";
    $content .= "  jQuery(document).ready(function() {";
    $content .= "    jQuery('#bc_genes').DataTable({";
    $content .= "    })";
    $content .= "  });";
    $content .= "</script>";
    return $content;
}

function bicluster_tfs_table_shortcode($attr, $content=null)
{
    $bicluster_name = get_query_var('bicluster');
    $source_url = get_option('source_url', '');
    $result_json = file_get_contents($source_url . "/api/v1.0.0/bicluster/" .
                                     rawurlencode($bicluster_name));
    $entries = json_decode($result_json)->tfs_bc;
    $content = "";
    $content = "<h3>Regulators for bicluster " . $bicluster_name . "</h3>";
    $content .= "<table id=\"bc_tfs\" class=\"stripe row-border\">";
    $content .= "  <thead><tr><th>Regulator</th><th>Role</th></tr></thead>";
    $content .= "  <tbody>";
    foreach ($entries as $e) {
        $content .= "    <tr><td><a href=\"index.php/regulator/?regulator=" . $e->tf . "\">" . $e->tf . "</a></td><td>" . $e->role . "</td></tr>";
    }
    $content .= "  </tbody>";
    $content .= "</table>";
    $content .= "<script>";
    $content .= "  jQuery(document).ready(function() {";
    $content .= "    jQuery('#bc_tfs').DataTable({";
    $content .= "    })";
    $content .= "  });";
    $content .= "</script>";
    return $content;
}

function bicluster_mutation_tfs_table_shortcode($attr, $content=null)
{
    $bicluster_name = get_query_var('bicluster');
    $source_url = get_option('source_url', '');
    $result_json = file_get_contents($source_url . "/api/v1.0.0/bicluster/" .
                                     rawurlencode($bicluster_name));
    $entries = json_decode($result_json)->mutations_tfs;
    $content = "";
    $content = "<h3>Mutations - Regulators for bicluster " . $bicluster_name . "</h3>";
    $content .= "<table id=\"bc_mutations_tfs\" class=\"stripe row-border\">";
    $content .= "  <thead><tr><th>Mutation</th><th>Role</th><th>Regulator</th></tr></thead>";
    $content .= "  <tbody>";
    foreach ($entries as $e) {
        $content .= "    <tr><td><a href=\"index.php/mutation/?mutation=" . $e->mutation . "\">" . $e->mutation . "</a></td><td>" . $e->role . "</td><td><a href=\"index.php/regulator/?regulator=" . $e->tf . "\">" . $e->tf . "</a></td></tr>";
    }
    $content .= "  </tbody>";
    $content .= "</table>";
    $content .= "<script>";
    $content .= "  jQuery(document).ready(function() {";
    $content .= "    jQuery('#bc_mutations_tfs').DataTable({";
    $content .= "    })";
    $content .= "  });";
    $content .= "</script>";
    return $content;
}


function search_box_shortcode($attr, $content)
{
    $ajax_action = "completions";
    $content = "<form action=\"" . esc_url(admin_url('admin-post.php')) .  "\" method=\"post\">";
    $content .= "Search Term: <input name=\"search_term\" type=\"text\" id=\"mmapi-search\"></input>";
    $content .= "<div style=\"margin-top: 5px;\"><input type=\"submit\" value=\"Search\"></input></div>";
    $content .= "<input type=\"hidden\" name=\"action\" value=\"search_mmapi\">";
    $content .= "</form>";
    $content .= "<script>";
    $content .= "  jQuery(document).ready(function() {";
    $content .= "    jQuery('#mmapi-search').autocomplete({";
    $content .= "      source: function(request, response) {";
    $content .= "                jQuery.ajax({ url: ajax_dt.ajax_url, type: 'POST', data: { action: '" . $ajax_action . "', term: request.term }, success: function(data) { response(data.completions) }});";
    $content .= "              },";
    $content .= "      minLength: 2";
    $content .= "    });";
    $content .= "  });";
    $content .= "</script>";
    return $content;
}

function search_results_shortcode($attr, $content)
{
    $search_term = $_GET['search_term'];
    $content = "<div>Search Term: " . $search_term . "</div>";
    $result_json = file_get_contents($source_url . "/api/v1.0.0/search/" .
                                     rawurlencode($search_term));
    $result = json_decode($result_json);
    if ($result->found == "no") {
        $content .= "<div>no entries found</div>";
    } else {
        $content .= "<div>yes, entries found, type: " . $result->data_type .  "</div>";
    }
    return $content;
}

function bicluster_cytoscape_shortcode($attr, $content)
{
    $content = "";
    $content .= "<div id=\"cytoscape\">CYTOSCAPE.JS HERE</div>";
    $content .= "<script>";
    $content .= "  jQuery(document).ready(function() {";
    $content .= "    var cy = cytoscape({";
    $content .= "      container: jQuery('#cytoscape'),";
    $content .= "      elements: [{data: {id: 'a'}}, {data: {id: 'b'}}, {data: {id: 'ab', source: 'a', target: 'b'}}]";
    $content .= "    });";
    $content .= "  });";
    $content .= "</script>";
    return $content;
}

function gene_biclusters_table_shortcode($attr, $content=null)
{
    $gene_name = get_query_var('gene');
    $source_url = get_option('source_url', '');
    $result_json = file_get_contents($source_url . "/api/v1.0.0/biclusters_for_gene/" .
                                     rawurlencode($gene_name));
    $entries = json_decode($result_json)->biclusters;
    $content = "";
    $content = "<h3>Biclusters for gene " . $gene_name . "</h3>";
    $content .= "<table id=\"biclusters\" class=\"stripe row-border\">";
    $content .= "  <thead><tr><th>Bicluster</th></tr></thead>";
    $content .= "  <tbody>";
    foreach ($entries as $e) {
        $content .= "    <tr><td><a href=\"index.php/bicluster/?bicluster=" . $e . "\">" . $e . "</a></td></tr>";
    }
    $content .= "  </tbody>";
    $content .= "</table>";
    $content .= "<script>";
    $content .= "  jQuery(document).ready(function() {";
    $content .= "    jQuery('#biclusters').DataTable({";
    $content .= "    })";
    $content .= "  });";
    $content .= "</script>";
    return $content;
}

function gene_info_shortcode($attr, $content=null)
{
    $gene_name = get_query_var('gene');
    $source_url = get_option('source_url', '');
    $result_json = file_get_contents($source_url . "/api/v1.0.0/gene_info/" .
                                     rawurlencode($gene_name));
    $gene_info = json_decode($result_json);
    $content = "";
    $content .= "<div><span class=\"entry-title\">Entrez ID: </span><span>" . $gene_info->entrez_id . "</span></div>";
    $content .= "<div><span class=\"entry-title\">Ensembl ID: </span><span>" . $gene_info->ensembl_id . "</span></div>";
    $content .= "<div><span class=\"entry-title\">Preferred Name: </span><span>" . $gene_info->entrez_id . "</span></div>";
    $content .= "";
    return $content;
}


function mmapi_add_shortcodes()
{
    add_shortcode('summary', 'summary_shortcode');
    add_shortcode('mutation_table', 'mutation_table_shortcode');
    add_shortcode('regulator_table', 'regulator_table_shortcode');

    // bicluster page short codes
    add_shortcode('bicluster_genes_table', 'bicluster_genes_table_shortcode');
    add_shortcode('bicluster_tfs_table', 'bicluster_tfs_table_shortcode');
    add_shortcode('bicluster_mutation_tfs_table', 'bicluster_mutation_tfs_table_shortcode');

    add_shortcode('mmapi_search_box', 'search_box_shortcode');
    add_shortcode('mmapi_search_results', 'search_results_shortcode');

    add_shortcode('gene_biclusters_table', 'gene_biclusters_table_shortcode');
    add_shortcode('gene_info', 'gene_info_shortcode');
    add_shortcode('bicluster_cytoscape', 'bicluster_cytoscape_shortcode');
}

?>