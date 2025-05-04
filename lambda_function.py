import boto3
import os
import json
import urllib.parse
import requests

rekognition = boto3.client('rekognition')
s3 = boto3.client('s3')

def lambda_handler(event, context):
    bucket = os.environ['BUCKET']
    token = os.environ['OPENAI_CUSTOM_KEY']
    key = urllib.parse.unquote_plus(event['Records'][0]['s3']['object']['key'])

    try:
        # Detect labels
        response = rekognition.detect_labels(
            Image={'S3Object': {'Bucket': bucket, 'Name': key}},
            MaxLabels=5
        )
        labels = [label['Name'] for label in response['Labels']]
        label_text = '\n'.join(labels)

        # Generate article using OpenAI
        article = generate_article(labels, token)

        # Combine output
        full_text = f"Image Labels:\n{label_text}\n\nFictional Article:\n{article}"
        txt_filename = key.rsplit('.', 1)[0] + '_labels_article.txt'

        # Upload text to S3
        s3.put_object(
            Bucket=bucket,
            Key=txt_filename,
            Body=full_text.encode('utf-8'),
            ContentType='text/plain'
        )

        print(f"Labels and article saved to {txt_filename}")
        return {
            'statusCode': 200,
            'body': json.dumps({'labels': labels, 'article': article})
        }

    except Exception as e:
        print(f"Error: {e}")
        raise e


def generate_article(labels, token):
    url = "https://is215-openai.upou.io/v1/chat/completions"
    headers = {
        "Content-Type": "application/json",
        "Authorization": f"Bearer {token}"
    }
    prompt = f"Write a fictional news article (max 200 words) about an image showing: {', '.join(labels)}."

    data = {
        "model": "gpt-3.5-turbo",
        "messages": [
            {
                "role": "user",
                "content": prompt
            }
        ]
    }

    response = requests.post(url, headers=headers, data=json.dumps(data))
    response.raise_for_status()
    return response.json()['choices'][0]['message']['content']
