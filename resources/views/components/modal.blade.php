<div class="{{ session('info_password') ? 'block' :'hidden'}} main-modal fixed w-full inset-0 z-50 overflow-hidden flex justify-center items-center animated fadeIn faster" style="background: rgba(0,0,0,.7);">
    <div class="border border-blue-500 shadow-lg modal-container bg-white w-full lg:w-5/12 md:max-w-11/12 mx-auto rounded-xl shadow-lg z-50 overflow-y-auto">
        <div class="modal-content py-4 text-left px-6">
            <!--Title-->
            <div class="flex justify-between items-center pb-3">
                <p class="text-2xl font-bold text-gray-500">Cambiar Contraseñar</p>
                <div class="modal-close cursor-pointer z-50" onclick="hideError()">
                    <svg class="fill-current text-gray-500" xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                        viewBox="0 0 18 18">
                        <path
                            d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z">
                        </path>
                    </svg>
                </div>
            </div>
            <!--Body-->
            <form method="POST" action="{{ route('users.change_password') }}">
                <div class="my-5 flex justify-center">
                    <div class="card w-full">
                        <div class="card-body">
                            @csrf
                            <div class="mb-4">
                                <label class="block text-grey-darker text-sm font-bold mb-2" for="pwc">
                                    Actual Contraseña
                                </label>
                                <input id="pwc" type="password" name="pwc" class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker">
                                @error('pwc')
                                    <span class="form_error text-red-500">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="mt-4">
                                <label class="block text-grey-darker text-sm font-bold mb-2" for="pw">
                                    Nueva Contraseña
                                </label>
                                <input id="pw" type="password" name="pw" autocomplete="new-pw" class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker">
                                @error('pw')
                                    <span class="form_error text-red-500">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="mt-4">
                                <label class="block text-grey-darker text-sm font-bold mb-2" for="pw_confirmation">
                                    Confirmar Nueva Contraseña
                                </label>
                                <input id="pw_confirmation" type="password" name="pw_confirmation" autocomplete="new-pw" class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker">
                                @error('pw_confirmation')
                                    <span class="form_error text-red-500">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                    <div class="flex justify-end pt-2 space-x-14">
                        <button type="button"
                            class="px-4 bg-gray-200 p-2 rounded text-black hover:bg-gray-300 font-semibold" onclick="hideError()">Cancelar</button>
                        <button type="submit"
                            class="px-4 bg-blue-500 p-2 ml-3 rounded-lg text-white hover:bg-teal-400">Aceptar</button>
                    </div>
            </form>
            <!--Footer-->
        </div>
    </div>
    <script>
        function hideError(){
            modalClose('main-modal');
            let errors = document.getElementsByClassName('form_error');
            [].forEach.call(errors, function (error) {
                error.style.display = 'none';
            });
        }
    </script>
</div>
