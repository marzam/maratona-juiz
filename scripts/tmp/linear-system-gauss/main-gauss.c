#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <math.h>
#include <assert.h>
#include <omp.h>
#include <time.h>
#define ERROR 1E-16
#define EPSILON 1E-17
struct stMatrix{
    double *A;
    double *B;
    double *X;
    int mn;
};
typedef struct stMatrix tpMatrix;
void LoadMatrixAndVector(char *matrixFile, char *vectorFile, tpMatrix *matrix);
void PrintMatrixAndVector(const tpMatrix *matrix);
void GaussMethod(tpMatrix *matrix);
void PrintX(double *X, const int size);
double max(double, double);
int main(int ac, char**av) {
  tpMatrix matrix;
  
  int      flagSave = atoi(av[4]);
  //fprintf(stdout, "\nMétodo iterativo de solução de sistema linear - Eliminação de Gauss - OMP\n");
  
  matrix.mn = atoi(av[3]);
  matrix.A = (double*) malloc (matrix.mn * matrix.mn *  sizeof(double));
  matrix.B = (double*) malloc (matrix.mn * sizeof(double));
  matrix.X = (double*) malloc (matrix.mn *  sizeof(double));

  //clock_t s = clock();
  LoadMatrixAndVector(av[1], av[2], &matrix);
  //clock_t e = clock();
  //float sec = (float)(e - s) / CLOCKS_PER_SEC;
  //printf("Time elapsed: %f\n", sec);
  
  //clock_t start = clock();
  GaussMethod(&matrix);
  //clock_t end = clock();
  //float seconds = (float)(end - start) / CLOCKS_PER_SEC;
  //printf("Time elapsed: %f\n", seconds);
  //printf("%f", seconds);

  if (flagSave == 1)
    PrintX(matrix.X, matrix.mn);

  //FILE *speedup = fopen("speedup.txt", "a");
  //fprintf(speedup, "%f\n", seconds);
  free(matrix.A);
  free(matrix.B);
  free(matrix.X);

  return EXIT_SUCCESS;
}

/*
 * Carrega a matrix e o vetor B do arquivo
 */
void LoadMatrixAndVector(char *matrixFile, char *vectorFile, tpMatrix *matrix){
  FILE *ptr = fopen(matrixFile, "rb+");
  assert(ptr != NULL);
  fread (matrix->A,sizeof(double), matrix->mn * matrix->mn, ptr);
  fclose(ptr);

  ptr = fopen(vectorFile, "rb+");
  assert(ptr != NULL);
  fread (matrix->B,sizeof(double), matrix->mn , ptr);
    
  fclose(ptr);
}

void PrintMatrixAndVector(const tpMatrix *matrix){

  fprintf(stdout, "Matrix (%d, %d)\n", matrix->mn, matrix->mn);
  for (int j = 0; j < matrix->mn; j++){
    for (int i = 0; i < matrix->mn; i++){
      int k = j * matrix->mn + i;
      fprintf(stdout, "%.7f ", matrix->A[k]);
    }
   fprintf(stdout, " \t %.7f \n", matrix->B[j]);
  }
}

void printAB(double *AB, int r, int c){
  int i, j;
  for (j = 0; j < r; j++){
    for (i = 0; i < c; i++){
      printf("%lf   ", AB[j * c + i]);   
    }
    printf("\n");   
      
  }

}

void GaussMethod(tpMatrix *matrix){
  double *AB =  (double*) malloc (matrix->mn * (matrix->mn + 1) *  sizeof(double));
  int r = matrix->mn,
      c = matrix->mn + 1;

  bzero(AB, matrix->mn * (matrix->mn + 1) *  sizeof(double));
  assert(AB != NULL);
  //copy matrix and B
  
  //#pragma omp parallel for collapse(2)
  #pragma omp for
  for (int j = 0; j < matrix->mn; j++){
    //#pragma omp for
    for (int i = 0; i < matrix->mn; i++){
      AB[j * c + i] = matrix->A[j * matrix->mn + i];   
    }
    AB[j  * c + matrix->mn] = matrix->B[j];   
  }
  
  //printAB(AB, r, c);
  //printf("\n----------------------------------------------------\n\n");
  double aij = 0.0;
  #pragma omp for
  for (int j = 0; j < r; j++){
    aij = AB[j * c + j];
    
    //#pragma omp for
    for (int i = j; i < c; i++){
        AB[j * c + i] = AB[j * c + i] / aij;
    }//end-for (int i = 0; i < c; i++){

    int l = j;
    for (int k = j + 1; k < r; k++){
        aij = AB[k * c + l];
      
      //#pragma omp for
      for (int i = j; i < c; i++){
        AB[k * c + i] = AB[k * c + i] - aij * AB[l * c + i];
      }
      

    }//for (int k = j+1; k < r; k++){
  }//end-for (int j = 0; j < r; j++){

  #pragma omp for
  for (int i = r-1; i >= 0; i--){
    double acc = 0.0;
    
    //#pragma omp for
    for (int k = i+1; k <  (c - 1); k++){
      acc += AB[i * c + k] * matrix->X[k];
    }
    matrix->X[i] = (AB[i * c + i] * AB[i * c + (c - 1)]) - acc;

  }

  
  /*
  printAB(AB, r, c);
  printf("\n===============================================\n");
  for (int i = 0; i < r; i++){
    printf("%lf\n", matrix->X[i]);
  }
  printf("\n===============================================\n");
  for (int j = 0; j < matrix->mn; j++){
    double acc = 0.0;
    for (int i = 0; i < matrix->mn; i++){
      acc += matrix->A[j * matrix->mn + i] * matrix->X[i];   
    }
    printf("%lf\n", acc);
  }
  */
  free(AB);


}

void PrintX(double *X, const int size){
  FILE *ptr = fopen("solucao.bin", "w+");
  assert(ptr != NULL);
  fwrite (&size , sizeof(int), 1, ptr);
  fwrite (X , sizeof(double), size, ptr);
  fclose(ptr);
}

