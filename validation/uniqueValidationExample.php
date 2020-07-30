 // $isBrandNameUnique =  $id ?  Rule::unique('company_brand', 'brand_name')
        //     ->where('company_id', CurrentApiCompany::id())
        //     ->ignore($id, 'id') : Rule::unique('company_brand', 'brand_name')
        //     ->where('company_id', $request->company_id);

        //$isBrandNameUnique = Rule::unique('company_brand', 'brand_name')
        //     ->where('company_id', $request->company_id)
        //     ->where('api_company_id', CurrentApiCompany::id());
        // if ($id) {
        //     $isBrandNameUnique->ignore($id);
        // }

        $uniqueBrandRule = Rule::unique('company_brand', 'brand_name')
            ->where(function ($query) use ($request, $id) {
                $query->where('company_id', $request->company_id)
                    ->where('api_company_id', CurrentApiCompany::id());

                if ($id) {
                    //ignore current row on update.
                    $query->where('id', '<>', $id);
                }
            });
