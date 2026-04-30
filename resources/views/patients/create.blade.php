@extends('layouts.app')

@section('title', 'New Patient Entry - hypercare')

@section('content')
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
        <div>
            <div class="flex items-center gap-2 mb-2">
                <span class="w-8 h-1 bg-accent rounded-full"></span>
                <p class="text-accent text-[0.7rem] font-black tracking-[0.2em] uppercase">Registration Desk</p>
            </div>
            <h1 class="text-3xl font-black tracking-tight text-text">New Patient Entry</h1>
            <p class="text-sm text-text-faint font-medium mt-1">Initialize clinical records for a new patient in the hospital directory</p>
        </div>
        <x-ui.button href="{{ route('patients.index') }}" variant="secondary" size="md">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to Directory
        </x-ui.button>
    </div>

    <div class="max-w-4xl mx-auto">
        <x-ui.card padding="none">
            <div class="p-10">
                @if ($errors->any())
                    <div class="mb-8 p-6 bg-danger/5 border border-danger/10 rounded-2xl animate-fade-in">
                        <div class="flex items-center mb-4">
                            <div class="w-10 h-10 rounded-xl bg-danger/10 text-danger flex items-center justify-center mr-4">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <span class="font-black text-danger uppercase tracking-widest text-xs">Registration Error</span>
                        </div>
                        <ul class="space-y-1.5 ml-14">
                            @foreach ($errors->all() as $error)
                                <li class="text-sm text-danger/80 font-bold">• {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('patients.store') }}" class="space-y-12">
                    @csrf

                    <!-- Section: Identity -->
                    <div>
                        <div class="flex items-center gap-4 mb-10">
                            <div class="w-12 h-12 rounded-[1.25rem] bg-accent/10 text-accent flex items-center justify-center font-black text-sm border border-accent/10 shadow-sm">01</div>
                            <div>
                                <h3 class="text-xl font-black text-text">Patient Identity</h3>
                                <p class="text-[0.65rem] text-text-faint font-bold uppercase tracking-wider">Legal and clinical identity details</p>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-10">
                            <div class="space-y-3">
                                <label for="medical_record_number" class="block text-[0.65rem] font-black text-text-faint uppercase tracking-[0.15em] ml-1">Medical Record No. (MRN)</label>
                                <div class="relative group">
                                    <input type="text" id="medical_record_number" value="{{ $nextMrn }}" disabled 
                                        class="w-full px-6 py-4.5 bg-bg border border-border/60 rounded-2xl text-accent font-mono font-black cursor-not-allowed shadow-inner transition-all text-sm">
                                    <div class="absolute right-4 top-1/2 -translate-y-1/2 px-2.5 py-1.5 bg-white border border-border/60 rounded-lg text-[0.55rem] font-black uppercase text-accent/60 tracking-widest shadow-sm">Auto Generated</div>
                                </div>
                            </div>

                            <div class="space-y-3">
                                <label for="name" class="block text-[0.65rem] font-black text-text-faint uppercase tracking-[0.15em] ml-1">Full Legal Name <span class="text-danger">*</span></label>
                                <input type="text" id="name" name="name" value="{{ old('name') }}" required 
                                    placeholder="e.g. John Doe"
                                    class="w-full px-6 py-4.5 bg-white border border-border/60 rounded-2xl text-text font-bold placeholder-text-faint/50 focus:ring-4 focus:ring-accent/10 focus:border-accent/40 transition-all outline-none text-sm">
                            </div>

                            <div class="space-y-3">
                                <label for="nik" class="block text-[0.65rem] font-black text-text-faint uppercase tracking-[0.15em] ml-1">National Identity No. (NIK)</label>
                                <input type="text" id="nik" name="nik" value="{{ old('nik') }}" maxlength="16" 
                                    placeholder="16-digit identity number"
                                    class="w-full px-6 py-4.5 bg-white border border-border/60 rounded-2xl text-text font-bold placeholder-text-faint/50 focus:ring-4 focus:ring-accent/10 focus:border-accent/40 transition-all outline-none font-mono text-sm">
                            </div>

                            <div class="space-y-3">
                                <label for="birth_date" class="block text-[0.65rem] font-black text-text-faint uppercase tracking-[0.15em] ml-1">Date of Birth</label>
                                <input type="date" id="birth_date" name="birth_date" value="{{ old('birth_date') }}"
                                    class="w-full px-6 py-4.5 bg-white border border-border/60 rounded-2xl text-text font-bold focus:ring-4 focus:ring-accent/10 focus:border-accent/40 transition-all outline-none text-sm">
                            </div>

                            <div class="space-y-3">
                                <label for="gender" class="block text-[0.65rem] font-black text-text-faint uppercase tracking-[0.15em] ml-1">Biological Gender <span class="text-danger">*</span></label>
                                <div class="relative group">
                                    <select id="gender" name="gender" required
                                        class="appearance-none w-full px-6 py-4.5 bg-white border border-border/60 rounded-2xl text-text font-bold focus:ring-4 focus:ring-accent/10 focus:border-accent/40 transition-all outline-none cursor-pointer text-sm">
                                        <option value="">-- Select Gender --</option>
                                        <option value="Laki-laki" {{ old('gender') == 'Laki-laki' ? 'selected' : '' }}>Male</option>
                                        <option value="Perempuan" {{ old('gender') == 'Perempuan' ? 'selected' : '' }}>Female</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center px-5 pointer-events-none text-text-faint group-hover:text-accent transition-colors">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9l6 6 6-6"/></svg>
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-3">
                                <label for="blood_type" class="block text-[0.65rem] font-black text-text-faint uppercase tracking-[0.15em] ml-1">Blood Type</label>
                                <div class="relative group">
                                    <select id="blood_type" name="blood_type"
                                        class="appearance-none w-full px-6 py-4.5 bg-white border border-border/60 rounded-2xl text-text font-bold focus:ring-4 focus:ring-accent/10 focus:border-accent/40 transition-all outline-none cursor-pointer text-sm">
                                        @foreach(['A', 'B', 'AB', 'O', '-'] as $bt)
                                            <option value="{{ $bt }}" {{ old('blood_type', '-') == $bt ? 'selected' : '' }}>{{ $bt == '-' ? 'Not Specified' : $bt }}</option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center px-5 pointer-events-none text-text-faint group-hover:text-accent transition-colors">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9l6 6 6-6"/></svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="h-px bg-gradient-to-r from-transparent via-border to-transparent opacity-50"></div>

                    <!-- Section: Administrative -->
                    <div>
                        <div class="flex items-center gap-4 mb-10">
                            <div class="w-12 h-12 rounded-[1.25rem] bg-success/10 text-success flex items-center justify-center font-black text-sm border border-success/10 shadow-sm">02</div>
                            <div>
                                <h3 class="text-xl font-black text-text">Contact & Payer Info</h3>
                                <p class="text-[0.65rem] text-text-faint font-bold uppercase tracking-wider">Administrative and billing coordination</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-10">
                            <div class="space-y-3">
                                <label for="phone" class="block text-[0.65rem] font-black text-text-faint uppercase tracking-[0.15em] ml-1">Primary Contact No.</label>
                                <input type="text" id="phone" name="phone" value="{{ old('phone') }}" 
                                    placeholder="e.g. 0812xxxxxx"
                                    class="w-full px-6 py-4.5 bg-white border border-border/60 rounded-2xl text-text font-bold placeholder-text-faint/50 focus:ring-4 focus:ring-accent/10 focus:border-accent/40 transition-all outline-none text-sm">
                            </div>

                            <div class="space-y-3">
                                <label for="insurance_type" class="block text-[0.65rem] font-black text-text-faint uppercase tracking-[0.15em] ml-1">Payer Classification <span class="text-danger">*</span></label>
                                <div class="relative group">
                                    <select id="insurance_type" name="insurance_type" required
                                        class="appearance-none w-full px-6 py-4.5 bg-white border border-border/60 rounded-2xl text-text font-bold focus:ring-4 focus:ring-accent/10 focus:border-accent/40 transition-all outline-none cursor-pointer text-sm">
                                        <option value="Umum" {{ old('insurance_type', 'Umum') == 'Umum' ? 'selected' : '' }}>General Private (Umum)</option>
                                        <option value="BPJS" {{ old('insurance_type') == 'BPJS' ? 'selected' : '' }}>Social Health (BPJS)</option>
                                        <option value="Asuransi" {{ old('insurance_type') == 'Asuransi' ? 'selected' : '' }}>Corporate Insurance</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center px-5 pointer-events-none text-text-faint group-hover:text-accent transition-colors">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9l6 6 6-6"/></svg>
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-3 md:col-span-2">
                                <label for="insurance_number" class="block text-[0.65rem] font-black text-text-faint uppercase tracking-[0.15em] ml-1">Payer ID / Policy Number</label>
                                <input type="text" id="insurance_number" name="insurance_number" value="{{ old('insurance_number') }}" 
                                    placeholder="Enter policy or card number"
                                    class="w-full px-6 py-4.5 bg-white border border-border/60 rounded-2xl text-text font-bold placeholder-text-faint/50 focus:ring-4 focus:ring-accent/10 focus:border-accent/40 transition-all outline-none text-sm">
                            </div>

                            <div class="space-y-3 md:col-span-2">
                                <label for="address" class="block text-[0.65rem] font-black text-text-faint uppercase tracking-[0.15em] ml-1">Current Residential Address</label>
                                <textarea id="address" name="address" rows="3" 
                                    placeholder="Enter complete address details..."
                                    class="w-full px-6 py-5 bg-white border border-border/60 rounded-2xl text-text font-bold placeholder-text-faint/50 focus:ring-4 focus:ring-accent/10 focus:border-accent/40 transition-all outline-none resize-none min-h-[140px] text-sm leading-relaxed">{{ old('address') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="pt-8 flex items-center gap-4">
                        <x-ui.button type="submit" variant="primary" size="lg" class="flex-1 shadow-xl shadow-accent/20">
                            Submit Patient Record
                        </x-ui.button>
                        <x-ui.button href="{{ route('patients.index') }}" variant="secondary" size="lg">
                            Cancel
                        </x-ui.button>
                    </div>
                </form>
            </div>
        </x-ui.card>
    </div>
@endsection
