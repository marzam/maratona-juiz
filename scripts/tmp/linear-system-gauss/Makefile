CPUC      = gcc
CFLAGS    = -g --std=c11 -m64 	 #     -Wunused-variable #-Wno-conversion-null -Wdelete-non-virtual-dtor
DEFS      =
INCLUDES  =
LIBDIR   = -L/usr/lib
LIBS     = -lm
LINK     =  $(LIBDIR) $(LIBS)
CPU_COMPILE_C  = $(CPUC) $(DEFS) $(INCLUDES) $(CFLAGS)

all:
	$(CPU_COMPILE_C) main-gauss.c  $(LINK)   -o gauss
	$(CPU_COMPILE_C) -fopenmp main-gauss-omp.c  $(LINK)   -o gauss_omp

clean:
	rm gauss
	rm gauss_omp
