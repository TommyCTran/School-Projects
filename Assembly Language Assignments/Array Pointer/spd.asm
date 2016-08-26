; Defined System calls
%define STDIN 0
%define STDOUT 1
%define SYSCALL_EXIT  1
%define SYSCALL_READ  3
%define SYSCALL_WRITE 4
%define BUFLEN 256

; Offsets for struct citizens
%define OFFSET_LAST_NAME 0
%define OFFSET_FIRST_NAME 20
%define OFFSET_NUM_ARRESTS 40
%define OFFSET_ARRESTS_PTR 44
%define OFFSET_NEXT 48

; Offsets for struct arrests
%define OFFSET_ARREST_YEAR	0
%define OFFSET_ARREST_MONTH 8
%define OFFSET_ARREST_DAY	12
%define OFFSET_ARREST_DESCRIPTION 16
%define SIZEOF_STRUCT_ARRESTS 56

	SECTION .data                   	; initialized data section
	extern citizens				; Request access to citizens	
msg1:   db "Enter Citizen's Last Name: "	; user prompt
len1:   equ $-msg1                      	; length of first message
msg2:   db "Enter Citizen's First Name: "	; user prompt
len2:   equ $-msg2                      	; length of first message
msg3:   db "Unknown last name: "		
len3:   equ $-msg3                      	
msg4:   db "Unknown name: "		
len4:   equ $-msg4                      	
msg5:   db "No arrests."		
len5:   equ $-msg5                      	
msg6:   db ", "		
len6:   equ $-msg6
msg7:   db "-"		
len7:   equ $-msg7
msg8:   db "", 10, 0		
len8:   equ $-msg8


	SECTION .bss                    ; uninitialized data section

lbuf:	resb BUFLEN			; buffer for last name
fbuf:	resb BUFLEN			; buffer for first name
llen:	resb 4                          ; length of last name
flen:	resb 4				; length of first name

        SECTION .text                   ; Code section
	global  _start                  ; let loader see entry point

_start:                                 ; address for gdb

	call	clear			; clears all registers

last_Name:
        ; prompt user for last name
        ;
        mov     eax, SYSCALL_WRITE      ; write function
        mov     ebx, STDOUT             ; Arg1: file descriptor
        mov     ecx, msg1               ; Arg2: addr of message
        mov     edx, len1               ; Arg3: length of message
        int     080h                    ; ask kernel to write

        ; read user input
        ;
        mov     eax, SYSCALL_READ       ; read function
        mov     ebx, STDIN              ; Arg 1: file descriptor
        mov     ecx, lbuf               ; Arg 2: address of buffer
        mov     edx, BUFLEN             ; Arg 3: buffer length
        int     080h

        mov     [llen], eax             ; save length of string read
      	
check_Last:
	; Checks the last name
	;
	nop
	
	; Gets citizen length into edx
	mov	eax, citizens
	add	eax, OFFSET_LAST_NAME
	call	length

	; Gets user input length into edi
	mov	edi, [llen]
	sub	edi, 1

	; Compare the user length to citizen length
	cmp	edi, edx		
	jne	last_Error			
	mov 	edi, 0

last_Loop:
	; Loop to compare user input and citizen 
	;
	nop

	; If index is equal to citizen length 
	; check the last name
	cmp 	edi, edx
	je	first_Name
	call 	last_Compare	
	inc	edi

	; if compare returns false jump to error
	cmp	ebx, 1
	je	last_Error
	jmp	last_Loop
	
last_Error:
	; error printing last name
        ;
	nop

        mov     eax, SYSCALL_WRITE      ; write function
        mov     ebx, STDOUT             ; Arg1: file descriptor
        mov     ecx, msg3               ; Arg2: addr of message
        mov     edx, len3               ; Arg3: length of message
        int     080h                    ; ask kernel to write

	mov     eax, SYSCALL_WRITE      ; write function
        mov     ebx, STDOUT             ; Arg1: file descriptor
        mov     ecx, lbuf		; Arg2: addr of message
        mov     edx, [llen]             ; Arg3: length of message
        int     080h                    ; ask kernel to write

	jmp 	exit			; Immediately exits program

first_Name:
	; prompt user for first name
        ;
        mov     eax, SYSCALL_WRITE      ; write function
        mov     ebx, STDOUT             ; Arg1: file descriptor
        mov     ecx, msg2               ; Arg2: addr of message
        mov     edx, len2               ; Arg3: length of message
        int     080h                    ; ask kernel to write

        ; read user input
        ;
        mov     eax, SYSCALL_READ       ; read function
        mov     ebx, STDIN              ; Arg 1: file descriptor
        mov     ecx, fbuf               ; Arg 2: address of buffer
        mov     edx, BUFLEN             ; Arg 3: buffer length
        int     080h

        mov     [flen], eax             ; save length of string read

check_First:
	; Checks the first name
	;
	nop
	
	; Gets citizen length into edx
	mov	eax, citizens		
	add	eax, OFFSET_FIRST_NAME
	call	length

	; Gets user input length into edi
	mov	edi, [flen]
	sub	edi, 1

	; Compare the user length to citizen length
	cmp	edi, edx		
	jne	first_Error			
	mov	edi, 0

first_Loop:
	; Loop to compare user input and citizen 
	;
	nop

	; If index is equal to citizen length 
	; check the first name
	cmp 	edi, edx
	je	arrest
	call 	first_Compare	
	inc	edi

	; if compare returns false jump to error
	cmp	ebx, 1
	je	first_Error
	jmp	first_Loop


first_Error:
	; error printing first name
        ;
	nop

        mov     eax, SYSCALL_WRITE      ; write function
        mov     ebx, STDOUT             ; Arg1: file descriptor
        mov     ecx, msg4               ; Arg2: addr of message
        mov     edx, len4               ; Arg3: length of message
        int     080h                    ; ask kernel to write

	mov     eax, SYSCALL_WRITE      ; write function
        mov     ebx, STDOUT             ; Arg1: file descriptor
        mov     ecx, lbuf		; Arg2: addr of message
        mov     edx, [llen]             ; Arg3: length of message
	dec	edx
        int     080h                    ; ask kernel to write

	mov     eax, SYSCALL_WRITE      ; write function
        mov     ebx, STDOUT             ; Arg1: file descriptor
        mov     ecx, msg6               ; Arg2: addr of message
        mov     edx, len6 	        ; Arg3: length of message
        int     080h                    ; ask kernel to write

	mov     eax, SYSCALL_WRITE      ; write function
        mov     ebx, STDOUT             ; Arg1: file descriptor
        mov     ecx, fbuf		; Arg2: addr of message
        mov     edx, [flen]             ; Arg3: length of message
        int     080h                    ; ask kernel to write

arrest:

	add	eax, OFFSET_NUM_ARRESTS
	cmp	eax, 0
	je	no_Arrest
	mov	eax, citizens
	add	eax, OFFSET_ARRESTS_PTR
	mov	eax, [eax]
	add	eax, OFFSET_ARREST_YEAR
	call	print	
	mov     eax, SYSCALL_WRITE      ; write function
        mov     ebx, STDOUT             ; Arg1: file descriptor
        mov     ecx, msg7		; Arg2: addr of message
        mov     edx, len7	        ; Arg3: length of message
        int     080h                    ; ask kernel to write
	mov	eax, citizens
	add	eax, OFFSET_ARRESTS_PTR
	mov	eax, [eax]
	add	eax, OFFSET_ARREST_MONTH
	call	print	
	mov     eax, SYSCALL_WRITE      ; write function
        mov     ebx, STDOUT             ; Arg1: file descriptor
        mov     ecx, msg7		; Arg2: addr of message
        mov     edx, len7	        ; Arg3: length of message
        int     080h                    ; ask kernel to write
	mov	eax, citizens
	add	eax, OFFSET_ARRESTS_PTR
	mov	eax, [eax]
	add	eax, OFFSET_ARREST_DAY
	call	print	
	mov     eax, SYSCALL_WRITE      ; write function
        mov     ebx, STDOUT             ; Arg1: file descriptor
        mov     ecx, msg8		; Arg2: addr of message
        mov     edx, len8	        ; Arg3: length of message
        int     080h                    ; ask kernel to write
	

	jmp	exit

no_Arrest:
	
	mov     eax, SYSCALL_WRITE      ; write function
        mov     ebx, STDOUT             ; Arg1: file descriptor
        mov     ecx, msg5		; Arg2: addr of message
        mov     edx, len5	        ; Arg3: length of message
        int     080h                    ; ask kernel to write
	
exit:   
	nop	
	mov     eax, SYSCALL_EXIT       ; exit function
        mov     ebx, 0                  ; exit code, 0=normal
        int     080h                    ; ask kernel to take over 

; Subroutine print
; writes null-terminated string with address in eax
;
print:
        ; find \0 character and count length of string
        ;
        mov     edi, eax                ; use edi as index
        mov     edx, 0                  ; initialize count

print_count:  
	cmp     [edi], byte 0           ; null char?
        je      end_print
        inc     edx                     ; update index & count
        inc     edi
        jmp     short print_count
end_print:

        ; make syscall to write
        ; edx already has length of string
        ;
        mov     ecx, eax                ; Arg3: addr of message
        mov     eax, SYSCALL_WRITE      ; write function
        mov     ebx, STDOUT             ; Arg1: file descriptor
        int     080h                    ; ask kernel to write
        ret                             

; Subroutine length
; places length of eax into edx
;
length:
        ; find \0 character and count length of string
        ;
        mov     edi, eax                ; use edi as index
        mov     edx, 0                  ; initialize count

length_count:  
	cmp     [edi], byte 0           ; null char?
        je      end_length
        inc     edx                     ; update index & count
        inc     edi
        jmp     short length_count    
end_length:

        ; make syscall to write
        ; edx already has length of string
        ;
        ret                             
   
; Subroutine compare last name
; compares the input string with the citizen string
;
last_Compare:
	
	mov	bl, [lbuf + edi]
	mov	bh, [eax]
	cmp 	bl, bh
	je	last_Equal
	mov	ebx, 1
	jmp	last_Done
last_Equal:
	inc	eax
	jmp	last_Done
last_Done:
	ret
	
; Subroutine compare first name
; compares the input string with the citizen string
;
first_Compare:
	
	mov	bl, [fbuf + edi]
	mov	bh, [eax]
	cmp 	bl, bh
	je	first_Equal
	mov	ebx, 1
	jmp	first_Done
first_Equal:
	inc	eax
	mov	ebx, 0
	jmp	first_Done
first_Done:
	ret
	

; Subroutine clear
; writes null-terminated string with address in eax
;
clear:
	; clear registers
	xor	eax, eax		; 
	xor 	ebx, ebx		;
	xor	ecx, ecx		; 
	xor	edx, edx		;
	xor	esi, esi		; 
	xor	edi, edi		;
	ret
