<?php

namespace App\Http\Controllers\Api\v2\Utility;

use App\Http\Controllers\Controller;
use App\Models\AllClass;
use App\Models\Blog;
use App\Models\City;
use App\Models\Country;
use App\Models\Division;
use App\Models\Upazila;
use App\Traits\AppResponse;
use App\Traits\HttpAppResponse;
use Illuminate\Http\Request;

class UtilityController extends Controller
{
    use HttpAppResponse;
    // All Blogs start
    public function all_blog()
    {
        $blogs = Blog::get();
        return $this->apiresponse(
            [
                'blogs' => $blogs,
            ],
            true,
            'All Class read succesfull.',
            AppResponse::HTTP_OK,
        );
    }
    public function blog_item($id)
    {
        $blog = Blog::select('id', 'user_id', 'name', 'image_path', 'description', 'pageview')
            ->where('id', $id)
            ->first();
        if (!$blog) {
            return $this->error(['message' => 'Blog not found'], false, 'Blog not found.', AppResponse::HTTP_NOT_FOUND);
        }
        $blog->pageview = $blog->pageview + 1;
        $blog->save();
        return $this->apiresponse(['blog' => $blog], true, 'Blog read successful.', AppResponse::HTTP_OK);
    }
    // All Class start
    public function all_class()
    {
        $allclass = AllClass::get(['id', 'name']);
        return $this->apiresponse(
            [
                'allclass' => $allclass,
            ],
            true,
            'All Class read succesfull.',
            AppResponse::HTTP_OK,
        );
    }
    // All Country start
    public function all_country()
    {
        $countrys = Country::where('is_active', 'on')->get(['id', 'code', 'name']);
        return $this->apiresponse(
            [
                'countries' => $countrys,
            ],
            true,
            'All Country read succesfull.',
            AppResponse::HTTP_OK,
        );
    }
    public function division($id)
    {
        $divisions = Division::where('country_id', $id)->get(['id', 'name']);
        return $this->apiresponse(
            [
                'divisions' => $divisions,
            ],
            true,
            'Division read succesfull.',
            AppResponse::HTTP_OK,
        );
    }
    // All Class start
    public function city($id)
    {
        $cities = City::where('division_id', $id)->get(['id', 'name']);
        return $this->apiresponse(
            [
                'cities' => $cities,
            ],
            true,
            'Cities read succesfull.',
            AppResponse::HTTP_OK,
        );
    }
    // All Upazila start
    public function upazila($id)
    {
        $upazilas = Upazila::where('city_id', $id)->get(['id', 'name']);
        return $this->apiresponse(
            [
                'upazilas' => $upazilas,
            ],
            true,
            'Upazila read succesfull.',
            AppResponse::HTTP_OK,
        );
    }
}
