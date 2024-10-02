public function show_profil()
    {
        $user = User::all();

        return view('admin.profil',compact('user'));

    }

    public function profil_delete($id)
    {
        $data = User::find($id);

        $user->delete();

        return redirect()->back()->with('message','Profil Berhasil Dihapus');

    }

    public function edit_profil($id)
    {
        $user = User::find($id);
        return view('admin.edit_profile', compact('user'));
   
    }

    public function update_profil(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'whatsapp' => 'required|string|max:255',
            'dinas' => 'required|string|max:255',
            'opd' => 'required|string|max:255',
            'alamat' => 'required|string',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user = User::find($id);
        $user->update($validated);

        
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        return redirect()->route('edit_profil', $id)->with('message', 'Profil berhasil diperbarui!');
    }

     <!-- Pagination Links -->
     <div class="pagination">
                <ul class="pagination">
                    @foreach ($tamu->links()->elements as $element)
                        @if (is_array($element))
                            @foreach ($element as $number => $link)
                                @if ($number == $tamu->currentPage())
                                    <li class="page-item active">
                                        <span class="page-link">{{ $number }}</span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $link }}">{{ $number }}</a>
                                    </li>
                                @endif
                            @endforeach
                        @endif
                    @endforeach
                </ul>
            </div>

            <div class="mb-4">
                    <h5>Total Entries by Dinas:</h5>
                    <ul class="list-group">
                        @foreach ($totalAgencies as $opd_id => $count)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $opd_id }} <span class="badge badge-primary badge-pill">{{ $count }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>