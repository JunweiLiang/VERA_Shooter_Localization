#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <math.h>
#include <time.h>
#include <assert.h>
#include <float.h>

#include <string>
using namespace std;

#define kk 200 //calculate how many closest index
#define Malloc(type,n) (type *)malloc((n)*sizeof(type))
	//data d 维，mfcc d 维
	//kmeans center 39维，＊4096

	//float dist[K];
int main(int argc, char** argv)
{
	if(argc != 6)
	{
		fprintf(stderr, "%s ctr_file ctr_count data_file data_dim output\n", argv[0]);
		exit(-1);
	}

	FILE *fpIn, *fpCtrs, *fpOut;
	int i, j, l;
	char tmp[165536];
	char *ptr1, *ptr2;
	float mindist;
	int bestctr;

	fpCtrs = fopen(argv[1], "r");
	assert(fpCtrs);
	int k = -1;
	sscanf(argv[2], "%d", &k);//k是cluster中心数
	assert( k > 0 );

	fpIn = fopen(argv[3], "r");

	assert(fpIn);

	int d = -1;
	sscanf(argv[4], "%d", &d);//d is the dimension of feature
	assert( d > 0 );

	fpOut = fopen(argv[5], "w");
	assert(fpOut);

	//float data[d];
	//float ctrs[k][d];
	float* data;
	float** ctrs;
	data = Malloc(float, d);
	ctrs = Malloc(float *, k);
	if ((data == NULL) || (ctrs == NULL))
	{
		printf("memory problem1.");
		exit(1);
	}
	for(i=0;i<k;++i)
	{
		ctrs[i] = Malloc(float, d);
		if (ctrs[i] == NULL)
		{
			printf("memory problem2.");
			exit(1);
		}
	}
	
	for(i=0; i<k; i++)//循环，每次读入一个中心点数据
	{
		fgets(tmp, 165535, fpCtrs);
		ptr1 = tmp;
		for(j=0; j<d; j++)
		{
			//读入kmeans
			ctrs[i][j] = atof(ptr1);
			ptr2 = strchr(ptr1, ' ');
			if(ptr2 != NULL)
				ptr1 = ptr2 + 1;
		}
	}

	//中心点浮点数保存在ctrs中，ctrs[centers][dims]

	//printf("processing %s\n", argv[3]);
	
	l = 0;
	
	//记录前n个最小的 index
	float closestDist[kk];
	int closestIndex[kk];

	while(fgets(tmp, 165535, fpIn) != NULL)//读取数据文件
	{

		l++;
		ptr1 = tmp;
		//对每一行读入d列
		for(i=0; i<d; i++)
		{
			//ptr1开始是整行数据的字符串
			data[i] = atof(ptr1);//data存储本行数据//atof会截断
			ptr2 = strchr(ptr1, ' ');//获取本行下一个数据
			if(ptr2 == NULL && i+1 != d)
			{
				fprintf(stderr, "format error in line %d(%d-D)!!\n", l, i);
				return -1;
			}
			ptr1 = ptr2+1;
		}

		if(i != d)//奇怪的情况
		{
			l--;
			continue;
		}
		/*
			初始最近临,记住 kk个最近的
		*/
		for(i=0;i<kk;i++)
		{
			closestDist[i] = FLT_MAX;
			closestIndex[i] = -1;
		}
		//k=4096
		//遍历每一个中心，计算本行数据data与每个一个中心的欧式距离(x-xi)^2+...+

		for(i=0; i<k; i++)
		{
			float cdist = 0.0;			
			for(j=0; j<d; j++)
			{		
				cdist += (data[j]-ctrs[i][j])*(data[j]-ctrs[i][j]);
				//printf("%f\n", cdist);
			}
			
			//dist[i] = cdist;
			
			//在这里其实可以同时排序了
			/*
				modified by chunwai, using closest[2][kk]//0 for dist,1 for index
				每次把前n个现在最近的dist的index存储
			*/
			//获取当前dist在closest中可以排的位置
			int theone = -1;
			//比最后一个大就都不用比较了
			if(cdist > closestDist[kk-1])
			{
				continue;
			}
			for(j=0;j<kk;++j)
			{
				//cdist比这个值小，就记住这个位置
				//float gap = ;
				if(cdist <= closestDist[j])
				{
					theone = j;
					break;
				}
			}
			//新来的dist比当前kk个其中一个小了,插入
			if(theone != -1)
			{	
				//全部往后挪
				for(j=kk-1;j>theone;--j)
				{
					closestDist[j] = closestDist[j-1];
					closestIndex[j] = closestIndex[j-1];
				}
				closestDist[theone] = cdist;
				closestIndex[theone] = i;
			}
			
			
		}

		/*
		//for debug
		for(i=0;i<kk;++i)
		{
			printf("%d ",closestIndex[i]);
		}
		printf("\n");
		if(l>30)
		{
			return 0;
		}
		*/
		/*
			以下不需要使用了，
		*/
		/*
		//dist记录每行与k个点的欧式距离
		float mindist;
		int minindex = 0;
		//kk =10//找10个最小的dist,每次把其标注为-1,并且直接输出 
		for(i=0; i<kk; i++)
		{
			mindist = FLT_MAX;
			//1~4096
			for(j=0; j<k; j++)
			{
				if(dist[j] == -1)
					continue;
				if(dist[j] <= mindist)
				{
					mindist = dist[j];
					minindex = j;
				}
			}
			dist[minindex] = -1;
			//fprintf(fpOut, " %d:%f", minindex, mindist);
			//distance is not used, ignore..save space
			fprintf(fpOut, " %d", minindex);
		}
		
		*/
		for(i=0;i<kk;++i)
		{
			fprintf(fpOut," %d",closestIndex[i]);
		}
		fprintf(fpOut, "\n");
	}
	//printf("%d feature points\n", l);	

	fclose(fpCtrs);
	fclose(fpIn);
	fclose(fpOut);	
	return 0;
}
