private function validateUserType(Request $request, $id = null) {
        
        $statusIdEnabled = Status::select('StatusId')
            ->where('StatusName','Enabled')
            ->first();
        
        //Add both GlobalScopes of Accommodation and status
        $uniqueUserTypeName = Rule::unique('UserTypes', 'UserTypeName')
        ->where(function ($query) use ($statusIdEnabled, $id) {
            return $query->where('AccommodationId', CurrentAccommodation::id())
            ->where('UserTypeId', '!=', $id ? : null)
            ->where('StatusId',$statusIdEnabled->StatusId);
        });

        $rules = [
            $id ? 'usertypename' : 'usertype' => ['required','string','min:4','max:50',$uniqueUserTypeName],
        ];

        $messages = [
            'required' => 'Usertype name is required!',
            'string'   => 'Usertype name should be a valid string.',
            'min'      => 'Usertype name should contain atleast :min character(s).',
            'max'      => 'Usertype name should not contain more than :max character(s).',
            'unique'   => 'This usertype name already exist.'
        ];

        $request->validate($rules,$messages);
    }
