<?php
class PaginationHelper {
    public static function getPaginationLinks($currentPage, $pageNum, $totalPages, $queryString) {
        $output = '<div id="menu">';
        if ($pageNum > 0 || $pageNum < $totalPages - 1) {
            $output.= '<div id="xzys">';
        }
        if ($pageNum > 0) {
            $output.= '<a href="'. sprintf("%s?pageNum_cj_rank=%d%s", $currentPage, 0, $queryString). '"><img src="imgs/1.png" width="50px" height="50px"></a> ';
        } else {
            $output.= '<a><img src="imgs/w.png" width="50px" height="0px"></a>';
        }
        if ($pageNum > 0) {
            $output.= '<a href="'. sprintf("%s?pageNum_cj_rank=%d%s", $currentPage, max(0, $pageNum - 1), $queryString). '"><img src="imgs/2.png" width="50px" height="50px"></a> ';
        } else {
            $output.= '<a><img src="imgs/w.png" width="50px" height="0px"></a>';
        }
        if ($pageNum + 1 < $totalPages) {
            $output.= '<a href="'. sprintf("%s?pageNum_cj_rank=%d%s", $currentPage, min($totalPages - 1, $pageNum + 1), $queryString). '"><img src="imgs/3.png" width="50px" height="50px"></a> ';
        } else {
            $output.= '<a><img src="imgs/w.png" width="50px" height="0px"></a>';
        }
        if ($pageNum + 1 < $totalPages) {
            $output.= '<a href="'. sprintf("%s?pageNum_cj_rank=%d%s", $currentPage, $totalPages - 1, $queryString). '"><img src="imgs/4.png" width="50px" height="50px"></a> ';
        } else {
            $output.= '<a><img src="imgs/w.png" width="50px" height="0px"></a>';
        }
        if ($pageNum > 0 || $pageNum < $totalPages - 1) {
            $output.= '</div>';
        }
        $output.= '</div>';
        return $output;
    }
}
?>    